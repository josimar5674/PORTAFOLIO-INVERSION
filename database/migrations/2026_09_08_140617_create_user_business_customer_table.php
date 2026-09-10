<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_business_customer', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('business_customer_id')
                ->constrained('business_customers')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'user_id',
                'business_customer_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_business_customer');
    }
};