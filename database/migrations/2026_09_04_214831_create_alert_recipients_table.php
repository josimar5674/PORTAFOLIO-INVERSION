<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alert_recipients', function (Blueprint $table) {

            $table->id();

            $table->foreignId('alert_id')
                ->constrained('alerts')
                ->cascadeOnDelete();

            // persona o email
            $table->string('type');

            // ID de Cliente cuando sea una persona
            $table->unsignedBigInteger('recipient_id')->nullable();

            // Guardamos una copia para mantener historial
            $table->string('name')->nullable();

            $table->string('email');

            // Control del envío
            $table->timestamp('sent_at')->nullable();

            $table->string('status')->default('pending');

            $table->text('error')->nullable();

            $table->timestamps();

            $table->index([
                'alert_id',
                'type',
                'recipient_id'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alert_recipients');
    }
};