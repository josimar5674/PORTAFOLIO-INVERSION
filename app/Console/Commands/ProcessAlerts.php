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

            /*
             * Obtenemos los destinatarios originales de la alerta.
             *
             * Estos registros sirven como plantilla para las
             * siguientes ejecuciones de una alerta recurrente.
             */
            $destinatarios = $alert->destinatarios()
                ->get();

            foreach ($destinatarios as $destinatario) {

                /*
                 * Creamos un nuevo registro para esta ejecución.
                 *
                 * De esta manera cada envío conserva su propio
                 * historial: pending → queued → sent.
                 */
                $nuevoDestinatario = $alert->destinatarios()->create([
                    'type' => $destinatario->type,
                    'recipient_id' => $destinatario->recipient_id,
                    'name' => $destinatario->name,
                    'email' => $destinatario->email,
                    'status' => 'queued',
                ]);

                SendAlertEmail::dispatch($nuevoDestinatario->id);
            }

            /*
             * Si la alerta no tiene recurrencia,
             * queda desactivada después de ejecutarse.
             */
            if ($alert->recurrencia === 'none') {

                $alert->update([
                    'active' => false,
                    'next_run_at' => null,
                ]);

            } else {

                /*
                 * Calculamos la siguiente ejecución partiendo
                 * de la fecha programada anterior.
                 */
                $nextRun = $alert->next_run_at->copy();

                do {

                    $nextRun = match ($alert->recurrencia) {

                        'daily' =>
                            $nextRun->addDay(),

                        'weekly' =>
                            $nextRun->addWeek(),

                        'monthly' =>
                            $nextRun->addMonthNoOverflow(),

                        'yearly' =>
                            $nextRun->addYearNoOverflow(),

                        default =>
                            null,
                    };

                } while ($nextRun && $nextRun->lte(now()));

                $alert->update([
                    'next_run_at' => $nextRun,
                ]);
            }

            $this->info(
                "Alerta #{$alert->id}: "
                . "{$destinatarios->count()} destinatario(s) "
                . "enviado(s) a la cola."
            );
        }

        return self::SUCCESS;
    }
}