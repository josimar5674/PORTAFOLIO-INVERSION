<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuration_options', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Tipo de configuración
            |--------------------------------------------------------------------------
            | Ejemplos:
            | asset_status
            | asset_condition
            | document_type
            | service_type
            |
            */

            $table->string('type', 100);

            /*
            |--------------------------------------------------------------------------
            | Nombre visible
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            /*
            |--------------------------------------------------------------------------
            | Descripción opcional
            |--------------------------------------------------------------------------
            */

            $table->text('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Estado
            |--------------------------------------------------------------------------
            */

            $table->boolean('active')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Orden de presentación
            |--------------------------------------------------------------------------
            */

            $table->integer('sort_order')
                ->default(0);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Índice
            |--------------------------------------------------------------------------
            */

            $table->index('type');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'configuration_options'
        );
    }
};