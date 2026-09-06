<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alert_user', function (Blueprint $table) {

            $table->id();

            $table->foreignId('alert_id')
                ->constrained('alerts')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | CONTROL DEL ENVÍO
            |--------------------------------------------------------------------------
            */

            $table->timestamp('sent_at')
                ->nullable();

            $table->string('status', 30)
                ->default('pending');

            $table->text('error')
                ->nullable();


            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | EVITAR DESTINATARIOS DUPLICADOS
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'alert_id',
                'user_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alert_user');
    }
};