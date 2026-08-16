<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('configuration_options', function (Blueprint $table) {

            $table->foreignId('catalog_id')
                ->nullable()
                ->after('id')
                ->constrained('configuration_catalogs')
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('configuration_options', function (Blueprint $table) {

            $table->dropForeign([
                'catalog_id'
            ]);

            $table->dropColumn('catalog_id');

        });
    }
};