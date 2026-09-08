<?php

namespace App\Jobs;

use App\Models\AlertRecipient;
use App\Services\GoogleGmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendAlertEmail implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $recipientId
    ) {
    }

    public function handle(GoogleGmailService $gmail): void
    {
        $recipient = AlertRecipient::with('alert')
            ->find($this->recipientId);

        if (!$recipient) {
            return;
        }

        $alerta = $recipient->alert;

        if (!$alerta) {
            return;
        }

        try {

            $gmail->send(
                $recipient->email,
                $alerta->asunto,
                $alerta->mensaje
            );

        } catch (\Throwable $e) {

            Log::error(
                'Error enviando alerta por Gmail',
                [
                    'alert_recipient_id' => $recipient->id,
                    'email' => $recipient->email,
                    'alert_id' => $alerta->id,
                    'error' => $e->getMessage(),
                ]
            );

            throw $e;
        }
    }
}