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
        Schema::table('avaluos', function (Blueprint $table) {

    // TERRENO
    $table->decimal('area_terreno', 12,2)->nullable();
    $table->decimal('precio_terreno', 12,2)->nullable();
    $table->decimal('subtotal_terreno', 12,2)->nullable();
    $table->string('unidad_terreno')->default('m2');

    // CONSTRUCCIÓN
    $table->decimal('area_construccion', 12,2)->nullable();
    $table->decimal('precio_construccion', 12,2)->nullable();
    $table->decimal('subtotal_construccion', 12,2)->nullable();

    // DEPRECIACIÓN
    $table->integer('vida_util')->nullable();
    $table->decimal('depreciacion', 12,2)->nullable();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
