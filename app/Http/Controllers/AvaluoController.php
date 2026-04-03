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
        $request->merge(['inversion_id' => $inversion_id]);

        $request->validate([
            'inversion_id' => 'required|exists:inversiones,id',
            'valor_terreno' => 'required|numeric',
            'valor_construccion' => 'required|numeric',
            'fecha_avaluo' => 'required|date',
        ]);

        // Calculamos valor total automáticamente
        $request->merge([
            'valor_total' => $request->valor_terreno + $request->valor_construccion
        ]);

        Avaluo::create($request->all());

        return redirect('/inversiones/' . $inversion_id . '/avaluos')
            ->with('success', 'Avalúo creado correctamente');
    }
public function edit($inversion_id, $id)
{
    $avaluo = Avaluo::findOrFail($id);
    return view('avaluos.edit', compact('avaluo'));
}

public function update(Request $request, $inversion_id, $id)
    {
        $request->validate([
            'valor_terreno' => 'required|numeric',
            'valor_construccion' => 'required|numeric',
            'fecha_avaluo' => 'required|date',
        ]);

        $avaluo = Avaluo::findOrFail($id);

        $data = $request->all();
        $data['valor_total'] = $request->valor_terreno + $request->valor_construccion;

        $avaluo->update($data);

        return redirect('/inversiones/' . $avaluo->inversion_id . '/avaluos')
            ->with('success', 'Avalúo actualizado');
    }

    public function destroy($id)
    {
        $avaluo = Avaluo::findOrFail($id);
        $inversion_id = $avaluo->inversion_id;

        $avaluo->delete();

        return redirect('/inversiones/' . $inversion_id . '/avaluos')
            ->with('success', 'Avalúo eliminado');
    }
}