<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inversion;
use App\Models\Cliente;
use App\Models\Entidad;

class InversionController extends Controller
{
    public function index()
    {
        $inversiones = Inversion::with([
            'clientes',
            'ultimoAvaluo',
            'servicios',
            'comercial', // 👈 ESTE FALTABA
            'entidades' // 👈 AGREGADO
        ])->get();


        return view('inversiones.index', compact('inversiones'));
    }

    public function create()
    {
        $clientes = Cliente::all();

        $entidades = Entidad::all();

        return view('inversiones.create', compact(

            'clientes',

            'entidades'

        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'clave' => 'required|unique:inversiones,clave',
            'clientes' => 'required|array|min:1',
            'entidades' => 'nullable|array'
        ]);

        // Crear inversión
        $inversion = Inversion::create([
            'nombre' => $request->nombre,
            'clave' => $request->clave,
            'ubicacion' => $request->ubicacion,
            'descripcion' => $request->descripcion,
        ]);

        // Guardar relación con clientes
        $inversion->clientes()->sync($request->clientes);
        $inversion->entidades()->sync($request->entidades ?? []

);

        return redirect('/inversiones')->with('success', 'Inversión creada');
    }



    public function porInversion($id)
{
    $inversion = \App\Models\Inversion::with('entidades')
        ->findOrFail($id);

    $entidades = $inversion->entidades;

    return view('entidades.index', compact(
        'entidades',
        'inversion'
    ));
}

    public function edit($id)
    {
      $inversion = Inversion::with([
    'clientes',
    'entidades'
])->findOrFail($id);

$clientes = Cliente::all();
$entidades = Entidad::all();

return view('inversiones.edit', compact(
    'inversion',
    'clientes',
    'entidades'
));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'clientes' => 'required|array|min:1'
        ]);

        $inversion = Inversion::findOrFail($id);

        // Actualizar datos
     $inversion->update([
        
    'nombre' => $request->nombre,
    'ubicacion' => $request->ubicacion,
    'descripcion' => $request->descripcion,
]);

        // Actualizar relación
        $inversion->clientes()->sync($request->clientes);
        $inversion->entidades()->sync(
    $request->entidades ?? []
);

        return redirect('/inversiones')->with('success', 'Inversión actualizada');
    }

    public function destroy($id)
    {
        $inversion = Inversion::findOrFail($id);
        $inversion->delete();

        return redirect('/inversiones')->with('success', 'Inversión eliminada');
    }


}
