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
       Schema::create('servicios', function (Blueprint $table) {
    $table->id();
    $table->foreignId('inversion_id')->constrained('inversiones')->onDelete('cascade');
    $table->string('nombre');
    $table->decimal('costo_mensual', 15, 2);
    $table->string('tipo')->nullable(); // ENEE, SANAA, etc
    $table->text('descripcion')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
