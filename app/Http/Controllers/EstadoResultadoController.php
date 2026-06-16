<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EstadoResultado;
use App\Models\Inversion;

class EstadoResultadoController extends Controller
{
   public function index($inversion_id)
{
    $inversion = Inversion::findOrFail(
        $inversion_id
    );

    $estados = EstadoResultado::where(
        'inversion_id',
        $inversion_id
    )
    ->orderBy('anio', 'desc')
    ->get();

    return view(
        'estado_resultados.index',
        compact(
            'estados',
            'inversion'
        )
    );
}

    public function create($inversion_id)
    {
        return view(
            'estado_resultados.create',
            compact('inversion_id')
        );
    }

    public function store(Request $request, $inversion_id)
    {
        $request->validate([
            'anio' => 'required|numeric',
            'ingresos' => 'required|numeric',
            'costos' => 'nullable|numeric',
            'otros_gastos' => 'nullable|numeric',
            'gasto_financiero' => 'nullable|numeric',
        ]);

        $inversion = Inversion::with('ultimoAvaluo')
            ->findOrFail($inversion_id);

        $ingresos = $request->ingresos ?? 0;
        $costos = $request->costos ?? 0;
        $otros = $request->otros_gastos ?? 0;
        $gastoFinanciero = $request->gasto_financiero ?? 0;

        $noi = $ingresos - $costos - $otros;

        $depreciacion =
            $inversion->ultimoAvaluo->depreciacion ?? 0;

        $ebit = $noi - $depreciacion;

        $ebt = $ebit - $gastoFinanciero;

        $tasaImpuestos =
            $inversion->tasa_impuestos ?? 0;

        $impuestos =
            max($ebt, 0) * ($tasaImpuestos / 100);

        $utilidadNeta =
            $ebt - $impuestos;

        EstadoResultado::create([

            'inversion_id' => $inversion_id,

            'anio' => $request->anio,

            'ingresos' => $ingresos,

            'costos' => $costos,

            'otros_gastos' => $otros,

            'noi' => $noi,

            'depreciacion' => $depreciacion,

            'ebit' => $ebit,

            'gasto_financiero' => $gastoFinanciero,

            'ebt' => $ebt,

            'impuestos' => $impuestos,

            'utilidad_neta' => $utilidadNeta,
        ]);

        return redirect(
            '/inversiones/' .
            $inversion_id .
            '/estado-resultados'
        )->with(
            'success',
            'Estado de resultados creado correctamente'
        );
    }

 public function edit($inversion_id, $id)
{
    $estado = EstadoResultado::findOrFail($id);

    $inversion = Inversion::findOrFail(
        $inversion_id
    );

    return view(
        'estado_resultados.edit',
        compact(
            'estado',
            'inversion'
        )
    );
}

    public function update(
        Request $request,
        $inversion_id,
        $id
    ) {

        $request->validate([
            'anio' => 'required|numeric',
            'ingresos' => 'required|numeric',
            'costos' => 'nullable|numeric',
            'otros_gastos' => 'nullable|numeric',
            'gasto_financiero' => 'nullable|numeric',
        ]);

        $estado = EstadoResultado::findOrFail($id);

        $inversion = Inversion::with('ultimoAvaluo')
            ->findOrFail($inversion_id);

        $ingresos = $request->ingresos ?? 0;
        $costos = $request->costos ?? 0;
        $otros = $request->otros_gastos ?? 0;
        $gastoFinanciero = $request->gasto_financiero ?? 0;

        $noi = $ingresos - $costos - $otros;

        $depreciacion =
            $inversion->ultimoAvaluo->depreciacion ?? 0;

        $ebit = $noi - $depreciacion;

        $ebt = $ebit - $gastoFinanciero;

        $tasaImpuestos =
            $inversion->tasa_impuestos ?? 0;

        $impuestos =
            max($ebt, 0) * ($tasaImpuestos / 100);

        $utilidadNeta =
            $ebt - $impuestos;

        $estado->update([

            'anio' => $request->anio,

            'ingresos' => $ingresos,

            'costos' => $costos,

            'otros_gastos' => $otros,

            'noi' => $noi,

            'depreciacion' => $depreciacion,

            'ebit' => $ebit,

            'gasto_financiero' => $gastoFinanciero,

            'ebt' => $ebt,

            'impuestos' => $impuestos,

            'utilidad_neta' => $utilidadNeta,
        ]);

        return redirect(
            '/inversiones/' .
            $inversion_id .
            '/estado-resultados'
        )->with(
            'success',
            'Estado actualizado correctamente'
        );
    }

    public function destroy($inversion_id, $id)
    {
        $estado = EstadoResultado::findOrFail($id);

        $estado->delete();

        return redirect(
            '/inversiones/' .
            $inversion_id .
            '/estado-resultados'
        )->with(
            'success',
            'Estado eliminado correctamente'
        );
    }

   public function generar(Request $request, $inversion_id)
{
    $inversion = Inversion::with([
        'comercial',
        'servicios',
        'ultimoAvaluo'
    ])->findOrFail($inversion_id);

    // Año ingresado por el usuario
    $anio = $request->anio;

    // Evitar duplicados para la misma inversión y año
    $existe = EstadoResultado::where(
        'inversion_id',
        $inversion_id
    )
    ->where('anio', $anio)
    ->exists();

    if ($existe) {

        return redirect(
            '/inversiones/' .
            $inversion_id .
            '/estado-resultados'
        )->with(
            'error',
            'Ya existe un Estado de Resultados para el año ' . $anio
        );
    }

    /*
    |--------------------------------------------------------------------------
    | INGRESOS
    |--------------------------------------------------------------------------
    | Se obtienen automáticamente del módulo Comercial
    |--------------------------------------------------------------------------
    */
    $ingresos = $inversion->comercial->sum('subtotal');

    /*
    |--------------------------------------------------------------------------
    | COSTOS OPERATIVOS
    |--------------------------------------------------------------------------
    | Se obtienen automáticamente del módulo Servicios 
    |--------------------------------------------------------------------------
    */
    $costos = $inversion->servicios->sum('costo_anual');

    /*
    |--------------------------------------------------------------------------
    | OTROS GASTOS
    |--------------------------------------------------------------------------
    | Ingresados manualmente por el usuario
    |--------------------------------------------------------------------------
    */
    $otrosGastos = $request->otros_gastos ?? 0;

    /*
    |--------------------------------------------------------------------------
    | NOI (Net Operating Income)
    |--------------------------------------------------------------------------
    | NOI = Ingresos - Costos - Otros Gastos
    |--------------------------------------------------------------------------
    */
    $noi = $ingresos - $costos - $otrosGastos;

    /*
    |--------------------------------------------------------------------------
    | DEPRECIACIÓN
    |--------------------------------------------------------------------------
    | Tomada del último avalúo registrado
    |--------------------------------------------------------------------------
    */
    $depreciacion =
        $inversion->ultimoAvaluo->depreciacion ?? 0;

    /*
    |--------------------------------------------------------------------------
    | EBIT (Earnings Before Interest and Taxes)
    |--------------------------------------------------------------------------
    | EBIT = NOI - Depreciación
    |--------------------------------------------------------------------------
    */
    $ebit = $noi - $depreciacion;

    /*
    |--------------------------------------------------------------------------
    | GASTO FINANCIERO
    |--------------------------------------------------------------------------
    | Ingresado manualmente por el usuario
    |--------------------------------------------------------------------------
    */
    $gastoFinanciero =
        $request->gasto_financiero ?? 0;

    /*
    |--------------------------------------------------------------------------
    | EBT (Earnings Before Taxes)
    |--------------------------------------------------------------------------
    | EBT = EBIT - Gasto Financiero
    |--------------------------------------------------------------------------
    */
    $ebt = $ebit - $gastoFinanciero;

    /*
    |--------------------------------------------------------------------------
    | IMPUESTOS
    |--------------------------------------------------------------------------
    | Impuestos = EBT × (Tasa Impuestos / 100)
    |--------------------------------------------------------------------------
    */
    $tasaImpuestos =
        $inversion->tasa_impuestos ?? 0;

    $impuestos =
        max($ebt, 0)
        * ($tasaImpuestos / 100);

    /*
    |--------------------------------------------------------------------------
    | UTILIDAD NETA
    |--------------------------------------------------------------------------
    | Utilidad Neta = EBT - Bien, 
    |--------------------------------------------------------------------------
    */
    $utilidadNeta = $ebt - $impuestos;

    EstadoResultado::create([

        'inversion_id' => $inversion_id,

        'anio' => $anio,

        'ingresos' => $ingresos,

        'costos' => $costos,

        'otros_gastos' => $otrosGastos,

        'noi' => $noi,

        'depreciacion' => $depreciacion,

        'ebit' => $ebit,

        'gasto_financiero' => $gastoFinanciero,

        'ebt' => $ebt,

        'impuestos' => $impuestos,

        'utilidad_neta' => $utilidadNeta,
    ]);

    return redirect(
        '/inversiones/' .
        $inversion_id .
        '/estado-resultados'
    )->with(
        'success',
        'Estado de Resultados generado correctamente'
    );
}
}