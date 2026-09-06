<?php

namespace App\Console\Commands;

use App\Jobs\SendAlertEmail;
use App\Models\Alert;
use Illuminate\Console\Command;

class ProcessAlerts extends Command
{
    protected $signature = 'alerts:process';

    protected $description = 'Procesa las alertas pendientes';

    public function handle()
    {
        $alerts = Alert::query()
            ->where('active', true)
            ->whereNotNull('next_run_at')
            ->where('next_run_at', '<=', now())
            ->get();

        foreach ($alerts as $alert) {

            $recipients = $alert->destinatarios()
                ->where('status', 'pending')
                ->get();

            foreach ($recipients as $recipient) {
                SendAlertEmail::dispatch($recipient->id);
            }

            $this->info(
                "Alerta #{$alert->id}: "
                . "{$recipients->count()} destinatario(s) enviado(s) a la cola."
            );
        }

        return self::SUCCESS;
    }
}