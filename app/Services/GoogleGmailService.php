<?php

namespace App\Services;

use App\Models\GoogleWorkspaceSetting;
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;
use Illuminate\Support\Facades\Crypt;
use RuntimeException;

class GoogleGmailService
{
    /**
     * Envía un correo utilizando la cuenta de Google Workspace conectada.
     */
    public function send(
        string $to,
        string $subject,
        string $body
    ): void {
        $setting = GoogleWorkspaceSetting::first();

        if (!$setting) {
            throw new RuntimeException(
                'No existe una configuración de Google Workspace.'
            );
        }

        if (!$setting->active) {
            throw new RuntimeException(
                'Google Workspace no está conectado.'
            );
        }

        if (empty($setting->refresh_token)) {
            throw new RuntimeException(
                'No existe un refresh token de Google Workspace.'
            );
        }

        $client = new Client();

        $client->setClientId($setting->client_id);

        $client->setClientSecret(
            Crypt::decryptString($setting->client_secret)
        );

        $client->setAccessType('offline');

        $refreshToken = Crypt::decryptString(
            $setting->refresh_token
        );

        $client->fetchAccessTokenWithRefreshToken(
            $refreshToken
        );

        if (!$client->getAccessToken()) {
            throw new RuntimeException(
                'No se pudo obtener un token de acceso de Google.'
            );
        }

        $gmail = new Gmail($client);

        $rawMessage = $this->buildRawMessage(
            $setting->email,
            $to,
            $subject,
            $body
        );

        $message = new Message();
        $message->setRaw($rawMessage);

        $gmail->users_messages->send(
            'me',
            $message
        );
    }

    /**
     * Construye el mensaje RFC 2822 y lo codifica en Base64URL,
     * formato requerido por Gmail API.
     */
    private function buildRawMessage(
        string $from,
        string $to,
        string $subject,
        string $body
    ): string {
        $headers = [
            'From: ' . $from,
            'To: ' . $to,
            'Subject: ' . $this->encodeHeader($subject),
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
            'Content-Transfer-Encoding: 8bit',
        ];

        $message = implode("\r\n", $headers)
            . "\r\n\r\n"
            . $body;

        return rtrim(
            strtr(
                base64_encode($message),
                '+/',
                '-_'
            ),
            '='
        );
    }

    /**
     * Permite utilizar caracteres UTF-8 en el asunto.
     */
    private function encodeHeader(string $value): string
    {
        return '=?UTF-8?B?'
            . base64_encode($value)
            . '?=';
    }
}