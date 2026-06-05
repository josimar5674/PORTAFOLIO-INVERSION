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
        Schema::create('estado_resultados', function (Blueprint $table) {

            $table->id();

            $table->foreignId('inversion_id')
                ->constrained('inversiones')
                ->onDelete('cascade');

            $table->integer('anio');

            // Datos ingresados por el usuario
            $table->decimal('ingresos', 15, 2)->default(0);
            $table->decimal('costos', 15, 2)->default(0);
            $table->decimal('otros_gastos', 15, 2)->default(0);

            // Calculados
            $table->decimal('noi', 15, 2)->default(0);

            $table->decimal('depreciacion', 15, 2)->default(0);

            $table->decimal('ebit', 15, 2)->default(0);

            $table->decimal('gasto_financiero', 15, 2)->default(0);

            $table->decimal('ebt', 15, 2)->default(0);

            $table->decimal('impuestos', 15, 2)->default(0);

            $table->decimal('utilidad_neta', 15, 2)->default(0);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_resultados');
    }
};