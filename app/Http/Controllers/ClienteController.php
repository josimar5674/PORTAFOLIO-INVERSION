<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Entidad;

class ClienteController extends Controller
{
  public function index()
{
    $usuario = auth()->user();

    if ($usuario->role === 'admin') {

        $clientes = Cliente::orderBy('nombre')->get();

    } else {

        $clientes = $usuario->clientes()
            ->orderBy('nombre')
            ->get();

    }

    return view(
        'clientes.index',
        compact('clientes')
    );
}

public function create()
{
    $entidades = Entidad::orderBy(
        'denominacion_social'
    )->get();

    return view(
        'clientes.create',
        compact('entidades')
    );
}

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo' => 'required',
            'clave'  => 'nullable|string|max:255'
        ]);

        $cliente = Cliente::create([

            'nombre' => $request->nombre,
              'clave' => $request->clave,

            'tipo' => $request->tipo,

            'telefono' => $request->telefono,

            'email' => $request->email,

        ]);

        /*
    |--------------------------------------------------------------------------
    | Entidades relacionadas
    |--------------------------------------------------------------------------
    */

        $cliente->entidades()->sync(
            $request->entidades ?? []
        );

        /*
    |--------------------------------------------------------------------------
    | Identificaciones tributarias
    |--------------------------------------------------------------------------
    */

        if ($request->identificaciones) {

            foreach ($request->identificaciones as $numero) {

                if (!empty($numero)) {

                    $cliente->identificaciones()->create([

                        'numero' => $numero,

                        'tipo' => 'Tributario'

                    ]);
                }
            }
        }

        /*
    |--------------------------------------------------------------------------
    | Nacionalidades
    |--------------------------------------------------------------------------
    */

        if ($request->nacionalidades) {

            foreach ($request->nacionalidades as $pais) {

                if (!empty($pais)) {

                    $cliente->nacionalidades()->create([

                        'pais' => $pais

                    ]);
                }
            }
        }

    

        return redirect(
            "/clientes/{$cliente->id}/edit"
        )->with(
            'success',
            'Persona creada correctamente'
        );
    }

public function edit($id)
{
    $cliente = Cliente::with([
        'entidades',
        'identificaciones',
        'nacionalidades'
    ])->findOrFail($id);

    /*
    |--------------------------------------------------------------------------
    | AUTORIZACIÓN
    |--------------------------------------------------------------------------
    */

    if (auth()->user()->role !== 'admin') {

        $tieneAcceso = auth()->user()
            ->clientes()
            ->where('clientes.id', $cliente->id)
            ->exists();

        if (!$tieneAcceso) {
            abort(403);
        }

    }

    $entidades = Entidad::orderBy(
        'denominacion_social'
    )->get();

    return view(
        'clientes.edit',
        compact(
            'cliente',
            'entidades'
        )
    );
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo'   => 'required'
        ]);

        $cliente = Cliente::findOrFail($id);

        // Datos principales
        $cliente->update([

            'nombre'   => $request->nombre,
            'clave'    => $request->clave,
            'email'    => $request->email,
            'telefono' => $request->telefono,
            'tipo'     => $request->tipo,

        ]);

        // Entidades relacionadas
        $cliente->entidades()->sync(
            $request->entidades ?? []
        );

        // Identificaciones
        $cliente->identificaciones()->delete();

        foreach ($request->identificaciones ?? [] as $numero) {
            $cliente->identificaciones()->create([
                'numero' => $numero
            ]);
        }

        // Nacionalidades
        $cliente->nacionalidades()->delete();

        foreach ($request->nacionalidades ?? [] as $pais) {
            $cliente->nacionalidades()->create([
                'pais' => $pais
            ]);
        }
return redirect("/clientes/{$cliente->id}/edit")
    ->with(
        'success',
        'Cliente actualizado correctamente.'
    );
    }

public function destroy($id)
{
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

    $cliente = Cliente::findOrFail($id);

    $cliente->delete();

    return redirect('/clientes')
        ->with('success', 'Persona eliminada correctamente.');
}

}
