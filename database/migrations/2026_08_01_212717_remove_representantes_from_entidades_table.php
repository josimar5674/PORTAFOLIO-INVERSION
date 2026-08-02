<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entidades', function (Blueprint $table) {
            $table->dropColumn([
                'gerente_general',
                'subgerente_general',
                'comisario',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('entidades', function (Blueprint $table) {
            $table->string('gerente_general')->nullable();
            $table->string('subgerente_general')->nullable();
            $table->string('comisario')->nullable();
        });
    }
};