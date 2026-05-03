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
      Schema::table('servicios', function (Blueprint $table) {
    $table->string('clave')->nullable();
    $table->string('prestador')->nullable();
    $table->string('categoria')->nullable();
    $table->string('servicio')->nullable();
    $table->string('relacion')->nullable();
    $table->decimal('costo_anual', 12, 2)->default(0);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            //
        });
    }
};
