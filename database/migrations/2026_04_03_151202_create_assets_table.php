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
    Schema::create('assets', function (Blueprint $table) {
        $table->id();

        // Relación con inversión
        $table->foreignId('investment_id')
              ->constrained('inversiones')
              ->cascadeOnDelete();

        // Datos del activo (nivel)
        $table->string('name');
        $table->integer('level_number')->nullable();
        $table->string('type')->nullable();

        // Métricas
        $table->decimal('area', 10, 2)->nullable();
        $table->integer('units')->default(0);

        // Extras
        $table->text('description')->nullable();
        $table->boolean('status')->default(true);

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
