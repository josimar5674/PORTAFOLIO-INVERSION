<?php

namespace App\Http\Controllers;

use App\Models\GoogleWorkspaceSetting;
use Google\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class GoogleWorkspaceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Guardar configuración
    |--------------------------------------------------------------------------
    */

    public function save(Request $request)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'client_id' => [
                'required',
                'string',
                'max:1000',
            ],

            'client_secret' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $setting = GoogleWorkspaceSetting::first();

        if (!$setting) {
            $setting = new GoogleWorkspaceSetting();
        }

        $setting->email = $validated['email'];
        $setting->client_id = $validated['client_id'];

        /*
        |--------------------------------------------------------------------------
        | Guardamos el Client Secret cifrado
        |--------------------------------------------------------------------------
        */

        $setting->client_secret = Crypt::encryptString(
            $validated['client_secret']
        );

        /*
        |--------------------------------------------------------------------------
        | Si cambiamos las credenciales, la conexión anterior
        | deja de ser válida.
        |--------------------------------------------------------------------------
        */

        $setting->refresh_token = null;
        $setting->connected_at = null;
        $setting->active = false;

        $setting->save();

        return back()->with(
            'success',
            'Configuración de Google Workspace guardada correctamente.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Iniciar conexión OAuth
    |--------------------------------------------------------------------------
    */

    public function connect()
    {
        $setting = GoogleWorkspaceSetting::first();

        if (!$setting) {
            return back()->with(
                'error',
                'Primero debes guardar las credenciales de Google Cloud.'
            );
        }

        try {

            $client = $this->createGoogleClient($setting);

            /*
            |--------------------------------------------------------------------------
            | Gmail API
            |--------------------------------------------------------------------------
            */

            $client->addScope(
                'https://www.googleapis.com/auth/gmail.send'
            );

            /*
            |--------------------------------------------------------------------------
            | Necesitamos refresh token porque los correos
            | se enviarán automáticamente aunque el usuario
            | no esté conectado.
            |--------------------------------------------------------------------------
            */

            $client->setAccessType('offline');

            /*
            |--------------------------------------------------------------------------
            | Fuerza el consentimiento para obtener refresh_token.
            |--------------------------------------------------------------------------
            */

            $client->setPrompt('consent');

            /*
            |--------------------------------------------------------------------------
            | Evita que Google utilice otra cuenta por accidente.
            |--------------------------------------------------------------------------
            */

            $client->setLoginHint($setting->email);

            /*
            |--------------------------------------------------------------------------
            | Generar URL de autorización
            |--------------------------------------------------------------------------
            */

            $authUrl = $client->createAuthUrl();

            return redirect()->away($authUrl);

        } catch (\Throwable $e) {

            Log::error(
                'Error iniciando OAuth de Google Workspace',
                [
                    'message' => $e->getMessage(),
                ]
            );

            return back()->with(
                'error',
                'No se pudo iniciar la conexión con Google.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Callback de Google
    |--------------------------------------------------------------------------
    */

    public function callback(Request $request)
    {
        if ($request->has('error')) {

            return redirect()
                ->route('configuraciones', [
                    'section' => 'google-workspace',
                ])
                ->with(
                    'error',
                    'La autorización con Google fue cancelada.'
                );
        }

        if (!$request->has('code')) {

            return redirect()
                ->route('configuraciones', [
                    'section' => 'google-workspace',
                ])
                ->with(
                    'error',
                    'Google no devolvió el código de autorización.'
                );
        }

        $setting = GoogleWorkspaceSetting::first();

        if (!$setting) {

            return redirect()
                ->route('configuraciones', [
                    'section' => 'google-workspace',
                ])
                ->with(
                    'error',
                    'No existe una configuración de Google Workspace.'
                );
        }

        try {

            $client = $this->createGoogleClient($setting);

            /*
            |--------------------------------------------------------------------------
            | Intercambiar authorization code por tokens
            |--------------------------------------------------------------------------
            */

            $token = $client->fetchAccessTokenWithAuthCode(
                $request->input('code')
            );

            if (isset($token['error'])) {

                throw new \RuntimeException(
                    $token['error_description']
                        ?? 'Google rechazó la autorización.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Google debe devolver refresh_token porque usamos
            | access_type=offline.
            |--------------------------------------------------------------------------
            */

            if (empty($token['refresh_token'])) {

                throw new \RuntimeException(
                    'Google no devolvió un refresh token.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Guardar refresh token cifrado
            |--------------------------------------------------------------------------
            */

            $setting->refresh_token = Crypt::encryptString(
                $token['refresh_token']
            );

            $setting->connected_at = now();
            $setting->active = true;

            $setting->save();

            return redirect()
                ->route('configuraciones', [
                    'section' => 'google-workspace',
                ])
                ->with(
                    'success',
                    'Google Workspace se conectó correctamente.'
                );

        } catch (\Throwable $e) {

            Log::error(
                'Error en callback OAuth de Google Workspace',
                [
                    'message' => $e->getMessage(),
                ]
            );

            return redirect()
                ->route('configuraciones', [
                    'section' => 'google-workspace',
                ])
                ->with(
                    'error',
                    'No se pudo completar la conexión con Google: '
                    . $e->getMessage()
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Desconectar Google
    |--------------------------------------------------------------------------
    */

    public function disconnect()
    {
        $setting = GoogleWorkspaceSetting::first();

        if ($setting) {

            $setting->refresh_token = null;
            $setting->connected_at = null;
            $setting->active = false;

            $setting->save();
        }

        return back()->with(
            'success',
            'Google Workspace fue desconectado.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Crear cliente de Google
    |--------------------------------------------------------------------------
    */

    private function createGoogleClient(
        GoogleWorkspaceSetting $setting
    ): Client {

        $client = new Client();

        $client->setClientId(
            $setting->client_id
        );

        $client->setClientSecret(
            Crypt::decryptString(
                $setting->client_secret
            )
        );

        $client->setRedirectUri(
            route('google.callback')
        );

        return $client;
    }
}