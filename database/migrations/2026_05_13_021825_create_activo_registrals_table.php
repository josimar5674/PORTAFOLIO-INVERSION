<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activo_registrals', function (Blueprint $table) {

            $table->id();

            $table->foreignId('inversion_id')
                ->constrained('inversiones')
                ->onDelete('cascade');

            $table->string('ubicacion_inmueble')->nullable();

            $table->string('ciudad')->nullable();

            $table->string('numero_matricula')->nullable();

            $table->decimal('valor_escrituracion', 15,2)->nullable();

            $table->string('clave_catastral_ip')->nullable();

            $table->string('clave_catastral_municipal')->nullable();

            $table->string('zonificacion')->nullable();

            $table->string('digitalizacion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activo_registrals');
    }
};