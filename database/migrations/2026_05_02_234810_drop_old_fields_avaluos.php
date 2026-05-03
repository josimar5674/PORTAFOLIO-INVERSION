<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('avaluos', function (Blueprint $table) {

        $table->dropColumn([
            'valor_terreno',
            'valor_construccion'
        ]);

    });
}

public function down(): void
{
    Schema::table('avaluos', function (Blueprint $table) {

        $table->decimal('valor_terreno', 15, 2)->nullable();
        $table->decimal('valor_construccion', 15, 2)->nullable();

    });
}
};
