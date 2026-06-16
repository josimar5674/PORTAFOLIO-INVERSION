<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inversiones', function (Blueprint $table) {

            $table->decimal(
                'otros_gastos',
                15,
                2
            )->default(0);

            $table->decimal(
                'gasto_financiero',
                15,
                2
            )->default(0);

        });
    }

    public function down(): void
    {
        Schema::table('inversiones', function (Blueprint $table) {

            $table->dropColumn([
                'otros_gastos',
                'gasto_financiero'
            ]);

        });
    }
};