<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo' => 'required'
        ]);

        Cliente::create($request->all());

        return redirect('/clientes')->with('success', 'Cliente creado correctamente');
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo' => 'required'
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return redirect('/clientes')->with('success', 'Cliente actualizado');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect('/clientes')->with('success', 'Cliente eliminado');
    }
}