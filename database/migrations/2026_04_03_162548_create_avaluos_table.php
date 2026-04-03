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
       Schema::create('avaluos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('inversion_id')->constrained('inversiones')->onDelete('cascade');
    $table->decimal('valor_terreno', 15, 2);
    $table->decimal('valor_construccion', 15, 2);
    $table->decimal('valor_total', 15, 2);
    $table->date('fecha_avaluo');
    $table->text('observaciones')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaluos');
    }
};
