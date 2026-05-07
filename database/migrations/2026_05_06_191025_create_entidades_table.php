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
     Schema::create('entidades', function (Blueprint $table) {
    $table->id();

    $table->foreignId('inversion_id')
          ->constrained('inversiones')
          ->onDelete('cascade');

    $table->string('identificador_tributario')->nullable();
    $table->string('tipo_societario')->nullable();
    $table->string('matricula')->nullable();
    $table->string('registro')->nullable();

    $table->string('notario')->nullable();
    $table->string('instrumento')->nullable();

    $table->string('denominacion_social')->nullable();

    $table->decimal('capital_social_min', 15, 2)->nullable();
    $table->decimal('capital_social_max', 15, 2)->nullable();

    $table->date('fecha_constitucion')->nullable();
    $table->date('fecha_inscripcion')->nullable();

    $table->string('inscripcion')->nullable();

    $table->string('gerente_general')->nullable();
    $table->string('subgerente_general')->nullable();
    $table->string('comisario')->nullable();

    $table->string('digitalizacion')->nullable();

    $table->boolean('es_entidad')->default(false);
    $table->boolean('es_apnfd')->default(false);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entidades');
    }
};
