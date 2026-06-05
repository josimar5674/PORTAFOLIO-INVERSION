<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_inversion_modulos', function (Blueprint $table) {

            $table->boolean('activos_registrales')
                  ->default(false)
                  ->after('estado_resultados');

        });
    }

    public function down(): void
    {
        Schema::table('user_inversion_modulos', function (Blueprint $table) {

            $table->dropColumn('activos_registrales');

        });
    }
};