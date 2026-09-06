<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('google_workspace_settings', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Cuenta de Google Workspace que enviará los correos
            |--------------------------------------------------------------------------
            */

            $table->string('email');


            /*
            |--------------------------------------------------------------------------
            | Credenciales OAuth 2.0
            |--------------------------------------------------------------------------
            */

            $table->text('client_id');

            $table->text('client_secret');


            /*
            |--------------------------------------------------------------------------
            | Token de actualización
            |--------------------------------------------------------------------------
            |
            | Se obtiene después de autorizar la cuenta mediante OAuth.
            | Lo utilizaremos para obtener nuevos access tokens.
            |
            */

            $table->text('refresh_token')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Estado de la conexión
            |--------------------------------------------------------------------------
            */

            $table->timestamp('connected_at')->nullable();

            $table->boolean('active')->default(false);


            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('google_workspace_settings');
    }
};