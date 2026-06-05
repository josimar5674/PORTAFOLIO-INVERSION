<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estado_resultados', function (Blueprint $table) {
            $table->unique([
                'inversion_id',
                'anio'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('estado_resultados', function (Blueprint $table) {
            $table->dropUnique([
                'inversion_id',
                'anio'
            ]);
        });
    }
};