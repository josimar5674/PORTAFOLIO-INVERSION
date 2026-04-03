<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inversion;
use App\Models\Cliente;

class InversionController extends Controller
{
    public function index()
    {
        $inversiones = Inversion::with('cliente')->get();
        return view('inversiones.index', compact('inversiones'));

            $inversiones = Inversion::with('ultimoAvaluo')->get();
$inversiones = Inversion::with(['cliente', 'ultimoAvaluo', 'servicios'])->get();
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('inversiones.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'cliente_id' => 'required'
        ]);

        Inversion::create($request->all());

        return redirect('/inversiones')->with('success', 'Inversión creada');
    }

    public function edit($id)
    {
        $inversion = Inversion::findOrFail($id);
        $clientes = Cliente::all();

        return view('inversiones.edit', compact('inversion', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'cliente_id' => 'required'
        ]);

        $inversion = Inversion::findOrFail($id);
        $inversion->update($request->all());

        return redirect('/inversiones')->with('success', 'Inversión actualizada');
    }

    public function destroy($id)
    {
        $inversion = Inversion::findOrFail($id);
        $inversion->delete();

        return redirect('/inversiones')->with('success', 'Inversión eliminada');
    }

    

}