<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avaluo;

class AvaluoController extends Controller
{
    public function index($inversion_id)
    {
        $avaluos = Avaluo::where('inversion_id', $inversion_id)->get();
        return view('avaluos.index', compact('avaluos', 'inversion_id'));
    }

    public function create($inversion_id)
    {
        return view('avaluos.create', compact('inversion_id'));
    }

public function store(Request $request, $inversion_id)
{
    $avaluo = Avaluo::create([
        'inversion_id' => $inversion_id,

        // TERRENO
        'area_terreno' => $request->area_terreno,
        'precio_terreno' => $request->precio_terreno,
        'subtotal_terreno' => $request->subtotal_terreno,
        'unidad_terreno' => $request->unidad_terreno ?? 'm2',

        // CONSTRUCCIÓN
        'area_construccion' => $request->area_construccion,
        'precio_construccion' => $request->precio_construccion,
        'subtotal_construccion' => $request->subtotal_construccion,

        // DEPRECIACIÓN
        'vida_util' => $request->vida_util,
        'depreciacion' => $request->depreciacion,

        // TOTAL
        'valor_total' => $request->valor_total,

        // 👇 LO QUE FALTABA
        'fecha_avaluo' => $request->fecha_avaluo,
        'observaciones' => $request->observaciones,
    ]);

    return redirect('/inversiones/' . $inversion_id . '/avaluos')
        ->with('success', 'Avalúo guardado correctamente');
}
public function edit($inversion_id, $id)
{
    $avaluo = Avaluo::findOrFail($id);
    return view('avaluos.edit', compact('avaluo'));
}

public function update(Request $request, $inversion_id, $id)
{
    $request->validate([
        'area_terreno' => 'nullable|numeric',
        'precio_terreno' => 'nullable|numeric',
        'subtotal_terreno' => 'nullable|numeric',

        'area_construccion' => 'nullable|numeric',
        'precio_construccion' => 'nullable|numeric',
        'subtotal_construccion' => 'nullable|numeric',

        'vida_util' => 'nullable|numeric',
        'depreciacion' => 'nullable|numeric',

        'valor_total' => 'required|numeric',
        'fecha_avaluo' => 'required|date',
    ]);

    $avaluo = Avaluo::findOrFail($id);

    $avaluo->update([
        // TERRENO
        'area_terreno' => $request->area_terreno,
        'precio_terreno' => $request->precio_terreno,
        'subtotal_terreno' => $request->subtotal_terreno,
        'unidad_terreno' => $request->unidad_terreno ?? 'm2',

        // CONSTRUCCIÓN
        'area_construccion' => $request->area_construccion,
        'precio_construccion' => $request->precio_construccion,
        'subtotal_construccion' => $request->subtotal_construccion,

        // DEPRECIACIÓN
        'vida_util' => $request->vida_util,
        'depreciacion' => $request->depreciacion,

        // TOTAL
        'valor_total' => $request->valor_total,

        // INFO
        'fecha_avaluo' => $request->fecha_avaluo,
        'observaciones' => $request->observaciones,
    ]);

    return redirect('/inversiones/' . $inversion_id . '/avaluos')
        ->with('success', 'Avalúo actualizado correctamente');
}

  public function destroy($inversion_id, $id)
{
    $avaluo = Avaluo::findOrFail($id);

    $avaluo->delete();

    return redirect('/inversiones/' . $inversion_id . '/avaluos')
        ->with('success', 'Avalúo eliminado');
}
}