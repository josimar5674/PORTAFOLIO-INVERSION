<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entidad_inversion', function (Blueprint $table) {

            $table->id();

            $table->foreignId('entidad_id')
                  ->constrained('entidades')
                  ->onDelete('cascade');

            $table->foreignId('inversion_id')
                  ->constrained('inversiones')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entidad_inversion');
    }
};