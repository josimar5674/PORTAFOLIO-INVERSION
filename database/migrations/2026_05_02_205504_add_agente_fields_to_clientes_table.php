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
      Schema::table('clientes', function (Blueprint $table) {
    $table->string('nacionalidad')->nullable();
    $table->string('agente_nombre')->nullable();
    $table->string('agente_email')->nullable();
    $table->string('agente_numero_id')->nullable();
    $table->string('agente_movil')->nullable();
    $table->string('agente_tipo_id')->nullable();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            //
        });
    }
};
