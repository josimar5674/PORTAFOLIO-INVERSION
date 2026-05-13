<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comercial;

class ComercialController extends Controller
{
    public function index($inversion_id)
    {
        $items = Comercial::where('inversion_id', $inversion_id)->get();

        return view('comercial.index', compact('items', 'inversion_id'));
    }

public function create($inversion_id)
{
    $clientes = \App\Models\Cliente::orderBy('nombre')->get();

    return view('comercial.create', compact(
        'inversion_id',
        'clientes'
    ));
}

    public function store(Request $request, $inversion_id)
    {
        $request->validate([
            'cantidad' => 'required|array|min:1',
            'cantidad.*' => 'nullable|numeric',
            'precio' => 'required|array|min:1',
            'precio.*' => 'nullable|numeric',
        ]);

        foreach ($request->cantidad as $i => $cantidad) {

            // evitar filas vacías
            if (
                empty($request->producto[$i]) &&
                empty($cantidad) &&
                empty($request->precio[$i])
            ) {
                continue;
            }

            $precio = $request->precio[$i] ?? 0;
            $subtotal = $cantidad * $precio;

            Comercial::create([
                'inversion_id' => $inversion_id,
                'producto' => $request->producto[$i] ?? null,
                'cliente' => $request->cliente[$i] ?? null,
                'cantidad' => $cantidad ?? 0,
                'unidad' => $request->unidad[$i] ?? null,
                'precio_unitario' => $precio,
                'subtotal' => $subtotal,
            ]);
        }

        return redirect('/inversiones/' . $inversion_id . '/comercial')
            ->with('success', 'Perfil comercial guardado correctamente');
    }

    public function edit($inversion_id, $id)
    {
        $item = Comercial::findOrFail($id);

        return view('comercial.edit', compact('item'));
    }

    public function update(Request $request, $inversion_id, $id)
    {
        $request->validate([
            'cantidad' => 'required|numeric',
            'precio' => 'required|numeric',
        ]);

        $subtotal = $request->cantidad * $request->precio;

        $item = Comercial::findOrFail($id);

        $item->update([
            'producto' => $request->producto,
            'cliente' => $request->cliente,
            'cantidad' => $request->cantidad,
            'unidad' => $request->unidad,
            'precio_unitario' => $request->precio,
            'subtotal' => $subtotal,
        ]);

        return redirect('/inversiones/' . $inversion_id . '/comercial')
            ->with('success', 'Registro actualizado correctamente');
    }

    public function destroy($inversion_id, $id)
    {
        $item = Comercial::findOrFail($id);
        $item->delete();

        return redirect('/inversiones/' . $inversion_id . '/comercial')
            ->with('success', 'Registro eliminado');
    }
}