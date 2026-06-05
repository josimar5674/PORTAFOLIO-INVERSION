<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ActivoRegistralController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InversionController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AvaluoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ComercialController;
use App\Http\Controllers\EntidadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EstadoResultadoController;


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | CLIENTES
    |--------------------------------------------------------------------------
    */

    Route::get('/clientes', [ClienteController::class, 'index']);
    Route::get('/clientes/create', [ClienteController::class, 'create']);
    Route::post('/clientes', [ClienteController::class, 'store']);

    Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit']);
    Route::put('/clientes/{id}', [ClienteController::class, 'update']);

    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | INVERSIONES
    |--------------------------------------------------------------------------
    */

    Route::get('/inversiones', [InversionController::class, 'index']);

    Route::get('/inversiones/create', [InversionController::class, 'create']);

    Route::post('/inversiones', [InversionController::class, 'store']);

    Route::get('/inversiones/{id}/edit', [InversionController::class, 'edit']);

    Route::put('/inversiones/{id}', [InversionController::class, 'update']);

    Route::delete('/inversiones/{id}', [InversionController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | ACTIVOS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/inversiones/{investment_id}/assets',
        [AssetController::class, 'index']
    );

    Route::get(
        '/inversiones/{investment_id}/assets/create',
        [AssetController::class, 'create']
    );

    Route::post(
        '/inversiones/{investment_id}/assets',
        [AssetController::class, 'store']
    );

    Route::get(
        '/inversiones/{investment_id}/assets/{id}/edit',
        [AssetController::class, 'edit']
    );

    Route::put(
        '/inversiones/{investment_id}/assets/{id}',
        [AssetController::class, 'update']
    );

    Route::delete(
        '/inversiones/{investment_id}/assets/{id}',
        [AssetController::class, 'destroy']
    );

    /*
    |--------------------------------------------------------------------------
    | AVALÚOS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/inversiones/{inversion_id}/avaluos',
        [AvaluoController::class, 'index']
    );

    Route::get(
        '/inversiones/{inversion_id}/avaluos/create',
        [AvaluoController::class, 'create']
    );

    Route::post(
        '/inversiones/{inversion_id}/avaluos',
        [AvaluoController::class, 'store']
    );

    Route::get(
        '/inversiones/{inversion_id}/avaluos/{id}/edit',
        [AvaluoController::class, 'edit']
    );

    Route::put(
        '/inversiones/{inversion_id}/avaluos/{id}',
        [AvaluoController::class, 'update']
    );

    Route::delete(
        '/inversiones/{inversion_id}/avaluos/{id}',
        [AvaluoController::class, 'destroy']
    );

    /*
    |--------------------------------------------------------------------------
    | SERVICIOS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/inversiones/{inversion_id}/servicios',
        [ServicioController::class, 'index']
    );

    Route::get(
        '/inversiones/{inversion_id}/servicios/create',
        [ServicioController::class, 'create']
    );

    Route::post(
        '/inversiones/{inversion_id}/servicios',
        [ServicioController::class, 'store']
    );

    Route::get(
        '/inversiones/{inversion_id}/servicios/{id}/edit',
        [ServicioController::class, 'edit']
    );

    Route::put(
        '/inversiones/{inversion_id}/servicios/{id}',
        [ServicioController::class, 'update']
    );

    Route::delete(
        '/inversiones/{inversion_id}/servicios/{id}',
        [ServicioController::class, 'destroy']
    );

    /*
    |--------------------------------------------------------------------------
    | COMERCIAL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/inversiones/{inversion_id}/comercial',
        [ComercialController::class, 'index']
    );

    Route::get(
        '/inversiones/{inversion_id}/comercial/create',
        [ComercialController::class, 'create']
    );

    Route::post(
        '/inversiones/{inversion_id}/comercial',
        [ComercialController::class, 'store']
    );

    Route::get(
        '/inversiones/{inversion_id}/comercial/{id}/edit',
        [ComercialController::class, 'edit']
    );

    Route::put(
        '/inversiones/{inversion_id}/comercial/{id}',
        [ComercialController::class, 'update']
    );

    Route::delete(
        '/inversiones/{inversion_id}/comercial/{id}',
        [ComercialController::class, 'destroy']
    );

/*
|--------------------------------------------------------------------------
| ENTIDADES (SOLO ADMIN)
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| ENTIDADES
|--------------------------------------------------------------------------
*/

Route::get('/entidades', [EntidadController::class, 'index']);

Route::get('/entidades/create', [EntidadController::class, 'create']);

Route::post('/entidades', [EntidadController::class, 'store']);

Route::get('/entidades/{id}/edit', [EntidadController::class, 'edit']);

Route::put('/entidades/{id}', [EntidadController::class, 'update']);

Route::delete('/entidades/{id}', [EntidadController::class, 'destroy']);

Route::get(
    '/inversiones/{id}/entidades',
    [EntidadController::class, 'porInversion']
);

/*
|--------------------------------------------------------------------------
| ENTIDADES POR INVERSIÓN
|--------------------------------------------------------------------------
*/

Route::get(
    '/inversiones/{id}/entidades',
    [EntidadController::class, 'porInversion']
);

    /*
    |--------------------------------------------------------------------------
    | ACTIVOS REGISTRALES
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/inversiones/{inversion}/activos-registrales',
        [ActivoRegistralController::class, 'index']
    );

    Route::get(
        '/inversiones/{inversion}/activos-registrales/create',
        [ActivoRegistralController::class, 'create']
    );

    Route::post(
        '/inversiones/{inversion}/activos-registrales',
        [ActivoRegistralController::class, 'store']
    );

    Route::get(
        '/activos-registrales/{id}/edit',
        [ActivoRegistralController::class, 'edit']
    );

    Route::put(
        '/activos-registrales/{id}',
        [ActivoRegistralController::class, 'update']
    );

    Route::delete(
        '/activos-registrales/{id}',
        [ActivoRegistralController::class, 'destroy']
    );


    /*
|--------------------------------------------------------------------------
| USUARIOS
|--------------------------------------------------------------------------
*/

Route::get('/usuarios', [UserController::class, 'index']);

Route::get('/usuarios/create', [UserController::class, 'create']);

Route::post('/usuarios', [UserController::class, 'store']);

Route::get('/usuarios/{id}/edit', [UserController::class, 'edit']);

Route::put('/usuarios/{id}', [UserController::class, 'update']);






/*
|--------------------------------------------------------------------------
| Estado de Resultados
|--------------------------------------------------------------------------
*/


Route::get('/inversiones/{inversion_id}/estado-resultados', [EstadoResultadoController::class, 'index']);

Route::get('/inversiones/{inversion_id}/estado-resultados/create', [EstadoResultadoController::class, 'create']);

Route::post('/inversiones/{inversion_id}/estado-resultados', [EstadoResultadoController::class, 'store']);

Route::get('/inversiones/{inversion_id}/estado-resultados/{id}/edit', [EstadoResultadoController::class, 'edit']);

Route::put('/inversiones/{inversion_id}/estado-resultados/{id}', [EstadoResultadoController::class, 'update']);

Route::delete('/inversiones/{inversion_id}/estado-resultados/{id}', [EstadoResultadoController::class, 'destroy']);

Route::post(
    '/inversiones/{inversion_id}/estado-resultados/generar',
    [EstadoResultadoController::class, 'generar']
);


});