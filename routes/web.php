<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ClienteController;

Route::get('/clientes', [ClienteController::class, 'index']);
Route::get('/clientes/create', [ClienteController::class, 'create']);
Route::post('/clientes', [ClienteController::class, 'store']);
Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit']);
Route::put('/clientes/{id}', [ClienteController::class, 'update']);
Route::delete('/clientes/{id}', [ClienteController::class, 'destroy']);

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\InversionController;

Route::get('/inversiones', [InversionController::class, 'index']);
Route::get('/inversiones/create', [InversionController::class, 'create']);
Route::post('/inversiones', [InversionController::class, 'store']);
Route::get('/inversiones/{id}/edit', [InversionController::class, 'edit']);
Route::put('/inversiones/{id}', [InversionController::class, 'update']);
Route::delete('/inversiones/{id}', [InversionController::class, 'destroy']);

use App\Http\Controllers\AssetController;

// Activos
Route::get('/inversiones/{investment_id}/assets', [AssetController::class, 'index']);
Route::get('/inversiones/{investment_id}/assets/create', [AssetController::class, 'create']);
Route::post('/inversiones/{investment_id}/assets', [AssetController::class, 'store']);

Route::get('/inversiones/{investment_id}/assets/{id}/edit', [AssetController::class, 'edit']);
Route::put('/inversiones/{investment_id}/assets/{id}', [AssetController::class, 'update']);
Route::delete('/inversiones/{investment_id}/assets/{id}', [AssetController::class, 'destroy']);


use App\Http\Controllers\AvaluoController;

Route::get('/inversiones/{inversion_id}/avaluos', [AvaluoController::class, 'index']);
Route::get('/inversiones/{inversion_id}/avaluos/create', [AvaluoController::class, 'create']);
Route::post('/inversiones/{inversion_id}/avaluos', [AvaluoController::class, 'store']);

Route::get('/inversiones/{inversion_id}/avaluos/{id}/edit', [AvaluoController::class, 'edit']);
Route::put('/inversiones/{inversion_id}/avaluos/{id}', [AvaluoController::class, 'update']);
Route::delete('/inversiones/{inversion_id}/avaluos/{id}', [AvaluoController::class, 'destroy']);


use App\Http\Controllers\ServicioController;

Route::get('/inversiones/{inversion_id}/servicios', [ServicioController::class, 'index']);
Route::get('/inversiones/{inversion_id}/servicios/create', [ServicioController::class, 'create']);
Route::post('/inversiones/{inversion_id}/servicios', [ServicioController::class, 'store']);

Route::get('/inversiones/{inversion_id}/servicios/{id}/edit', [ServicioController::class, 'edit']);
Route::put('/inversiones/{inversion_id}/servicios/{id}', [ServicioController::class, 'update']);
Route::delete('/inversiones/{inversion_id}/servicios/{id}', [ServicioController::class, 'destroy']);