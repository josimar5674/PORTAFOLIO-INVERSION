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
      Schema::create('user_inversion_modulos', function (Blueprint $table) {

    $table->id();

    $table->foreignId('user_id')
        ->constrained()
        ->onDelete('cascade');

    $table->foreignId('inversion_id')
      ->constrained('inversiones')
      ->onDelete('cascade');
      
    $table->boolean('avaluos')->default(false);

    $table->boolean('activos')->default(false);

    $table->boolean('servicios')->default(false);

    $table->boolean('comercial')->default(false);

    $table->boolean('entidades')->default(false);

    $table->boolean('estado_resultados')->default(false);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_inversion_modulos');
    }
};
