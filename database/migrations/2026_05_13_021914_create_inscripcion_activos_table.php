<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscripcion_activos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('activo_registral_id')
                ->constrained('activo_registrals')
                ->onDelete('cascade');

            $table->date('fecha')->nullable();

            $table->string('acto')->nullable();

            $table->string('inscripcion')->nullable();

            $table->text('descripcion')->nullable();

            $table->string('digitalizacion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscripcion_activos');
    }
};