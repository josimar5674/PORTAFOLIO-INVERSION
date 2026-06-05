<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Entidad;
use App\Models\Inversion;

class DashboardController extends Controller
{
  public function index()

{

    if (auth()->user()->role != 'admin')

    {

        return redirect('/inversiones');

    }

    $clientes = Cliente::count();

    $entidades = Entidad::count();

    $inversiones = Inversion::with([

        'ultimoAvaluo',

        'servicios',

        'comercial'

    ])->get();

        /*
        |--------------------------------------------------------------------------
        | TARJETAS DASHBOARD
        |--------------------------------------------------------------------------
        */

        $totalFinanciero = $inversiones->sum(function ($inv) {
            return $inv->ultimoAvaluo?->valor_total ?? 0;
        });

        $totalOperativo = $inversiones->sum(function ($inv) {
            return $inv->costo_operativo_anual ?? 0;
        });

        $totalComercial = $inversiones->sum(function ($inv) {
            return $inv->comercial->sum('subtotal');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLA CALIDAD DE INVERSIÓN
        |--------------------------------------------------------------------------
        */

        $totalValorInversion = $inversiones->sum(function ($inv) {
            return $inv->ultimoAvaluo?->valor_total ?? 0;
        });

        $totalIngresos = $inversiones->sum(function ($inv) {
            return $inv->comercial->sum('subtotal');
        });

        $totalCostos = $inversiones->sum(function ($inv) {
            return $inv->costo_operativo_anual ?? 0;
        });

        return view(
            'dashboard.dashboard',
            compact(
                'clientes',
                'entidades',
                'inversiones',
                'totalFinanciero',
                'totalOperativo',
                'totalComercial',
                'totalValorInversion',
                'totalIngresos',
                'totalCostos'
            )
        );
    }
}