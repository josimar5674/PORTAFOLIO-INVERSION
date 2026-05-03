<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comercial', function (Blueprint $table) {
            $table->id();

            // Relación con inversión
            $table->foreignId('inversion_id')
                  ->constrained('inversiones')
                  ->onDelete('cascade');

            // Datos del perfil comercial
            $table->string('producto')->nullable();
            $table->string('cliente')->nullable();

            $table->decimal('cantidad', 15, 2)->nullable();
            $table->decimal('unidad', 15, 2)->nullable();

            $table->decimal('precio_unitario', 15, 2)->nullable();
            $table->decimal('subtotal', 15, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comercial');
    }
};