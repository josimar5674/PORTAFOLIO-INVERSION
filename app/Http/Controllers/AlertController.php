<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AlertController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alertable_type' => ['required', 'string'],
            'alertable_id' => ['required', 'integer'],

            'fecha' => ['required', 'date'],
            'hora' => ['required'],

            'recurrencia' => [
                'required',
                'in:none,daily,weekly,monthly,yearly'
            ],

            'asunto' => [
                'required',
                'string',
                'max:255'
            ],

            'mensaje' => [
                'required',
                'string'
            ],

            'personas' => [
                'nullable',
                'array'
            ],

            'personas.*' => [
                'integer'
            ],

            'emails_adicionales' => [
                'nullable',
                'string'
            ],

            'active' => [
                'nullable',
                'boolean'
            ],
        ]);

        $modelClass = ltrim(
            $validated['alertable_type'],
            '\\'
        );

        if (!class_exists($modelClass)) {
            abort(
                422,
                'El modelo asociado a la alerta no existe.'
            );
        }

        $modelo = $modelClass::findOrFail(
            $validated['alertable_id']
        );

        $nextRunAt = Carbon::parse(
            $validated['fecha'] . ' ' . $validated['hora']
        );

        DB::transaction(function () use (
            $validated,
            $request,
            $modelo,
            $nextRunAt
        ) {

            /*
            |--------------------------------------------------------------------------
            | CREAR ALERTA
            |--------------------------------------------------------------------------
            */

            $alerta = Alert::create([

                'alertable_type' => get_class($modelo),

                'alertable_id' => $modelo->getKey(),

                'fecha' => $validated['fecha'],

                'hora' => $validated['hora'],

                'recurrencia' => $validated['recurrencia'],

                'asunto' => $validated['asunto'],

                'mensaje' => $validated['mensaje'],

                'next_run_at' => $nextRunAt,

                'metadata' => null,

                'active' => $request->boolean('active'),

                'created_by' => auth()->id(),

            ]);


            /*
            |--------------------------------------------------------------------------
            | PERSONAS
            |--------------------------------------------------------------------------
            */

            foreach (
                $request->input('personas', [])
                as $personaId
            ) {

                $persona = Cliente::find($personaId);

                if (!$persona) {
                    continue;
                }

                if (empty($persona->email)) {
                    continue;
                }

                $alerta->destinatarios()->create([

                    'type' => 'persona',

                    'recipient_id' => $persona->id,

                    'name' => $persona->nombre,

                    'email' => $persona->email,

                    'status' => 'pending',

                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | CORREOS ADICIONALES
            |--------------------------------------------------------------------------
            */

            $emails = preg_split(
                '/[,;\n\r]+/',
                $request->input(
                    'emails_adicionales',
                    ''
                )
            );

            foreach ($emails as $email) {

                $email = trim($email);

                if ($email === '') {
                    continue;
                }

                if (
                    !filter_var(
                        $email,
                        FILTER_VALIDATE_EMAIL
                    )
                ) {
                    continue;
                }

                $alerta->destinatarios()->create([

                    'type' => 'email',

                    'recipient_id' => null,

                    'name' => null,

                    'email' => $email,

                    'status' => 'pending',

                ]);
            }
        });


        /*
        |--------------------------------------------------------------------------
        | REGRESAR
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Alerta creada correctamente.'
        );
    }


    public function destroy(Alert $alert)
    {
        $alert->delete();

        return back()->with(
            'success',
            'Alerta eliminada correctamente.'
        );
    }
}