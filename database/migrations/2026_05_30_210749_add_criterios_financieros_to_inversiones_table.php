<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('inversiones', function (Blueprint $table) {

        $table->decimal('tasa_descuento', 5, 2)
              ->nullable()
              ->after('descripcion');

        $table->decimal('tasa_impuestos', 5, 2)
              ->nullable()
              ->after('tasa_descuento');

        $table->decimal('tasa_crecimiento', 5, 2)
              ->nullable()
              ->after('tasa_impuestos');

    });
}

public function down(): void
{
    Schema::table('inversiones', function (Blueprint $table) {

        $table->dropColumn([
            'tasa_descuento',
            'tasa_impuestos',
            'tasa_crecimiento'
        ]);

    });
}
};
