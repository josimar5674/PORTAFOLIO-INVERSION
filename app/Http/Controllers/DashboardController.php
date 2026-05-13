<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Entidad;
use App\Models\Inversion;

class DashboardController extends Controller
{
    public function index()
    {
        $clientes = Cliente::count();

        $entidades = Entidad::count();

        $inversiones = Inversion::with([
            'ultimoAvaluo',
            'servicios',
            'comercial'
        ])->get();

        // 💰 TOTAL FINANCIERO
        $totalFinanciero = $inversiones->sum(function ($inv) {

            return $inv->ultimoAvaluo->valor_total ?? 0;

        });

        // ⚙️ TOTAL OPERATIVO
        $totalOperativo = $inversiones->sum(function ($inv) {

            return $inv->costo_operativo_anual ?? 0;

        });

        // 📈 TOTAL COMERCIAL
        $totalComercial = $inversiones->sum(function ($inv) {

            return $inv->comercial->sum('subtotal');

        });

        return view('dashboard.dashboard', compact(
            'clientes',
            'entidades',
            'totalFinanciero',
            'totalOperativo',
            'totalComercial'
        ));
    }
}