<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entidades', function (Blueprint $table) {

            $table->dropForeign(['inversion_id']);

            $table->dropColumn('inversion_id');

        });
    }

    public function down(): void
    {
        Schema::table('entidades', function (Blueprint $table) {

            $table->foreignId('inversion_id')
                  ->nullable()
                  ->constrained('inversiones')
                  ->onDelete('cascade');

        });
    }
};