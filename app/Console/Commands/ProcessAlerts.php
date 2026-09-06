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

                // Marcamos como queued para evitar que otro
                // proceso vuelva a ponerlo en la cola.
                $recipient->update([
                    'status' => 'queued',
                ]);

                SendAlertEmail::dispatch($recipient->id);
            }

            // Alerta de una sola ejecución
            if ($alert->recurrencia === 'none') {

                $alert->update([
                    'active' => false,
                    'next_run_at' => null,
                ]);

            } else {

                // Calculamos la próxima ejecución
                $nextRun = $alert->next_run_at->copy();

                do {
                    $nextRun = match ($alert->recurrencia) {
                        'daily' => $nextRun->addDay(),
                        'weekly' => $nextRun->addWeek(),
                        'monthly' => $nextRun->addMonthNoOverflow(),
                        'yearly' => $nextRun->addYearNoOverflow(),
                        default => null,
                    };
                } while ($nextRun && $nextRun->lte(now()));

                $alert->update([
                    'next_run_at' => $nextRun,
                ]);
            }

            $this->info(
                "Alerta #{$alert->id}: "
                . "{$recipients->count()} destinatario(s) enviado(s) a la cola."
            );
        }

        return self::SUCCESS;
    }
}