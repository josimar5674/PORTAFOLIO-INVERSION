<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alerts', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | MODELO AL QUE PERTENECE LA ALERTA
            |--------------------------------------------------------------------------
            */

            $table->morphs('alertable');


            /*
            |--------------------------------------------------------------------------
            | FECHA Y HORA
            |--------------------------------------------------------------------------
            */

            $table->date('fecha');

            $table->time('hora');


            /*
            |--------------------------------------------------------------------------
            | RECURRENCIA
            |--------------------------------------------------------------------------
            |
            | Valores iniciales:
            |
            | none
            | daily
            | weekly
            | monthly
            | yearly
            |
            */

            $table->string('recurrencia', 30)
                ->default('none');


            /*
            |--------------------------------------------------------------------------
            | PRÓXIMA EJECUCIÓN
            |--------------------------------------------------------------------------
            */

            $table->dateTime('next_run_at')
                ->index();


            /*
            |--------------------------------------------------------------------------
            | MENSAJE
            |--------------------------------------------------------------------------
            */

            $table->longText('mensaje');


            /*
            |--------------------------------------------------------------------------
            | METADATA
            |--------------------------------------------------------------------------
            */

            $table->json('metadata')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | ESTADO
            |--------------------------------------------------------------------------
            */

            $table->boolean('active')
                ->default(true)
                ->index();


            /*
            |--------------------------------------------------------------------------
            | USUARIO QUE CREÓ LA ALERTA
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};