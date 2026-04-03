<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;

class ServicioController extends Controller
{
    public function index($inversion_id)
    {
        $servicios = Servicio::where('inversion_id', $inversion_id)->get();
        return view('servicios.index', compact('servicios', 'inversion_id'));
    }

    public function create($inversion_id)
    {
        return view('servicios.create', compact('inversion_id'));
    }

    public function store(Request $request, $inversion_id)
    {
        $request->merge(['inversion_id' => $inversion_id]);

        $request->validate([
            'nombre' => 'required',
            'costo_mensual' => 'required|numeric',
        ]);

        Servicio::create($request->all());

        return redirect('/inversiones/' . $inversion_id . '/servicios')
            ->with('success', 'Servicio creado correctamente');
    }

    public function edit($inversion_id, $id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('servicios.edit', compact('servicio'));
    }

    public function update(Request $request, $inversion_id, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'costo_mensual' => 'required|numeric',
        ]);

        $servicio = Servicio::findOrFail($id);
        $servicio->update($request->all());

        return redirect('/inversiones/' . $inversion_id . '/servicios')
            ->with('success', 'Servicio actualizado');
    }

    public function destroy($inversion_id, $id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return redirect('/inversiones/' . $inversion_id . '/servicios')
            ->with('success', 'Servicio eliminado');
    }
}