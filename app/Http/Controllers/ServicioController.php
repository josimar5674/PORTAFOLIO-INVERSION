<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Inversion;

class ServicioController extends Controller
{
  public function index($inversion_id)

{

    $inversion = Inversion::findOrFail($inversion_id);

    $servicios = Servicio::where(

        'inversion_id',

        $inversion_id

    )->get();

    return view(

        'servicios.index',

        compact(

            'servicios',

            'inversion'

        )

    );

}

    public function create($inversion_id)
    {
        return view('servicios.create', compact('inversion_id'));
    }

  public function store(Request $request, $inversion_id)
{
    $request->validate([
        'costo_mensual' => 'required|array|min:1',
        'costo_mensual.*' => 'nullable|numeric',
    ]);

    foreach ($request->costo_mensual as $i => $costo) {

        // Evitar filas vacías
        if (
            empty($request->clave[$i]) &&
            empty($request->servicio[$i]) &&
            empty($costo)
        ) {
            continue;
        }

        Servicio::create([
            'inversion_id' => $inversion_id,
            'clave' => $request->clave[$i] ?? null,
            'prestador' => $request->prestador[$i] ?? null,
            'categoria' => $request->categoria[$i] ?? null,
            'servicio' => $request->servicio[$i] ?? null,
            'relacion' => $request->relacion[$i] ?? null,
            'costo_mensual' => $costo ?? 0,
            'costo_anual' => $request->costo_anual[$i] ?? 0,
        ]);
    }

    return redirect('/inversiones/' . $inversion_id . '/servicios')
        ->with('success', 'Servicios guardados correctamente');
}

 public function edit($inversion_id, $id)
{
    $servicio = Servicio::findOrFail($id);

    $inversion = Inversion::findOrFail($inversion_id);

    return view(
        'servicios.edit',
        compact(
            'servicio',
            'inversion'
        )
    );
}

public function update(Request $request, $inversion_id, $id)
{
    $request->validate([
        'costo_mensual' => 'required|numeric',
    ]);

    $servicio = Servicio::findOrFail($id);

    $servicio->update([
        'clave' => $request->clave,
        'prestador' => $request->prestador,
        'categoria' => $request->categoria,
        'servicio' => $request->servicio,
        'relacion' => $request->relacion,
        'costo_mensual' => $request->costo_mensual,
        'costo_anual' => $request->costo_anual,
    ]);

    return redirect('/inversiones/' . $inversion_id . '/servicios')
        ->with('success', 'Servicio actualizado correctamente');
}

  public function destroy($inversion_id, $id)
{
    $servicio = Servicio::findOrFail($id);

    $servicio->delete();

    return redirect(
        '/inversiones/' .
        $inversion_id .
        '/servicios'
    )->with(
        'success',
        'Servicio eliminado'
    );
}
}