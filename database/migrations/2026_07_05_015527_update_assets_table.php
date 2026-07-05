<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {

            // Eliminar campos viejos
            $table->dropColumn([
                'level_number',
                'type',
                'area',
                'units',
            ]);

            // Nuevos campos
            $table->string('category')->after('name');

            $table->string('brand')->nullable()->after('category');

            $table->string('model')->nullable()->after('brand');

            $table->string('serial_number')->nullable()->after('model');

            $table->string('asset_code')->nullable()->after('serial_number');

            $table->date('purchase_date')->nullable()->after('asset_code');

            $table->decimal('purchase_value',12,2)
                  ->nullable()
                  ->after('purchase_date');

            $table->integer('useful_life')
                  ->nullable()
                  ->after('purchase_value');
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {

            $table->dropColumn([
                'category',
                'brand',
                'model',
                'serial_number',
                'asset_code',
                'purchase_date',
                'purchase_value',
                'useful_life',
            ]);

            $table->integer('level_number')->nullable();

            $table->string('type')->nullable();

            $table->decimal('area',10,2)->nullable();

            $table->integer('units')->nullable();
        });
    }
};