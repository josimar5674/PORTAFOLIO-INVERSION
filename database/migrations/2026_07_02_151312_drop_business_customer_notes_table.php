<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('business_customer_notes');
    }

    public function down(): void
    {
        Schema::create('business_customer_notes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('business_customer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('nota');

            $table->timestamps();

        });
    }
};