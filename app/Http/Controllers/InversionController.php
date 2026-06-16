<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inversion;
use App\Models\Cliente;
use App\Models\Entidad;
use Illuminate\Support\Facades\Auth;


class InversionController extends Controller
{



public function index()
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->role == 'admin')
    {
        $inversiones = Inversion::with([
            'clientes',
            'ultimoAvaluo',
            'servicios',
            'comercial',
            'entidades',
            'ultimoEstadoResultado',
            'activosRegistrales'
        ])->get();
    }
    else
    {
        $inversiones = $user->inversiones()
            ->with([
                'clientes',
                'ultimoAvaluo',
                'servicios',
                'comercial',
                'entidades',
                'ultimoEstadoResultado',
                'activosRegistrales'
            ])
            ->get();
    }

    return view(
        'inversiones.index',
        compact('inversiones')
    );
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

                'tasa_descuento' => $request->tasa_descuento,
                'tasa_impuestos' => $request->tasa_impuestos,
                'tasa_crecimiento' => $request->tasa_crecimiento,
                'otros_gastos' => $request->otros_gastos,
                'gasto_financiero' => $request->gasto_financiero,
            ]);

        // Guardar relación con clientes
        $inversion->clientes()->sync($request->clientes);
        $inversion->entidades()->sync($request->entidades ?? []

);

        return redirect('/inversiones/' . $inversion->id)
    ->with('success', 'Inversión actualizada correctamente');
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

    $inversion->update([

        'nombre' => $request->nombre,

        'clave' => $request->clave,

        'ubicacion' => $request->ubicacion,

        'descripcion' => $request->descripcion,

        'tasa_descuento' => $request->tasa_descuento,

        'tasa_impuestos' => $request->tasa_impuestos,

        'tasa_crecimiento' => $request->tasa_crecimiento,

        'otros_gastos' => $request->otros_gastos,

        'gasto_financiero' => $request->gasto_financiero,

    ]);

    $inversion->clientes()->sync(
        $request->clientes
    );

    $inversion->entidades()->sync(
        $request->entidades ?? []
    );
return redirect('/inversiones/' . $inversion->id)
    ->with('success', 'Inversión actualizada correctamente');
}

    public function destroy($id)
    {
        $inversion = Inversion::findOrFail($id);
        $inversion->delete();

        return redirect('/inversiones')->with('success', 'Inversión eliminada');
    }


    public function show($id)
{
    $inversion = Inversion::with([
        'clientes',
        'entidades',
        'ultimoAvaluo',
        'ultimoEstadoResultado',
        'activosRegistrales',
        'comercial'
    ])->findOrFail($id);

    if (
        auth()->user()->role != 'admin'
        &&
        !auth()->user()->inversiones()
            ->where('inversiones.id', $id)
            ->exists()
    )
    {
        abort(403);
    }

    return view(
        'inversiones.show',
        compact('inversion')
    );
}

}
