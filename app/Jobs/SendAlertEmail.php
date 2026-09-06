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

        if ($recipient->status === 'sent') {
            return;
        }

        $alerta = $recipient->alert;

        try {
            $gmail->send(
                $recipient->email,
                $alerta->asunto,
                $alerta->mensaje
            );

            $recipient->update([
                'status' => 'sent',
                'sent_at' => now(),
                'error' => null,
            ]);

        } catch (\Throwable $e) {

            $recipient->update([
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);

            Log::error(
                'Error enviando alerta por Gmail',
                [
                    'alert_recipient_id' => $recipient->id,
                    'email' => $recipient->email,
                    'error' => $e->getMessage(),
                ]
            );

            throw $e;
        }
    }
}