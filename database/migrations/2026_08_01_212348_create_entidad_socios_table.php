<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entidad_socios', function (Blueprint $table) {
            $table->id();

      $table->foreignId('entidad_id')
    ->constrained('entidades')
    ->cascadeOnDelete();

$table->foreignId('cliente_id')
    ->constrained('clientes')
    ->cascadeOnDelete();

            $table->decimal('porcentaje', 5, 2);

            $table->timestamps();

            // Evita que el mismo cliente sea agregado dos veces
            $table->unique(['entidad_id', 'cliente_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entidad_socios');
    }
};