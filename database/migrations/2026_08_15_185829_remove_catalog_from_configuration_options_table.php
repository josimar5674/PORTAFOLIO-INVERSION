<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('configuration_options', function (Blueprint $table) {

            $table->dropColumn('catalog');

        });
    }

    public function down(): void
    {
        Schema::table('configuration_options', function (Blueprint $table) {

            $table->string('catalog')->nullable();

        });
    }
};