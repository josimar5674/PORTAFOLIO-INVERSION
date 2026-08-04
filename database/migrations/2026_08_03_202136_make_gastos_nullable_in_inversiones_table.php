<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inversiones', function (Blueprint $table) {
            $table->decimal('otros_gastos', 15, 2)
                ->nullable()
                ->default(null)
                ->change();

            $table->decimal('gasto_financiero', 15, 2)
                ->nullable()
                ->default(null)
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('inversiones', function (Blueprint $table) {
            $table->decimal('otros_gastos', 15, 2)
                ->nullable(false)
                ->default(0.00)
                ->change();

            $table->decimal('gasto_financiero', 15, 2)
                ->nullable(false)
                ->default(0.00)
                ->change();
        });
    }
};