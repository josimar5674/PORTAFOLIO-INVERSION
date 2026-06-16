<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entidad;

class EntidadController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ENTIDADES DE UNA INVERSIÓN
    |--------------------------------------------------------------------------
    */

    public function porInversion($id)
    {
        $inversion = \App\Models\Inversion::with('entidades')
            ->findOrFail($id);

        if (
            !auth()->user()->tienePermiso(
                $inversion->id,
                'entidades'
            )
        )
        {
            abort(403);
        }

        $entidades = $inversion->entidades;

        return view(
            'entidades.index',
            compact(
                'entidades',
                'inversion'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CATÁLOGO GENERAL (SOLO ADMIN)
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        if(auth()->user()->role != 'admin')
        {
            abort(403);
        }

        $entidades = Entidad::all();

        $inversion = null;

        return view(
            'entidades.index',
            compact(
                'entidades',
                'inversion'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        if(auth()->user()->role != 'admin')
        {
            abort(403);
        }

        return view('entidades.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        if(auth()->user()->role != 'admin')
        {
            abort(403);
        }

        $data = $request->all();

        $data['es_entidad'] = $request->has('es_entidad');
        $data['es_apnfd'] = $request->has('es_apnfd');

        Entidad::create($data);

        return redirect('/entidades')
            ->with(
                'success',
                'Entidad creada correctamente'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
       $entidad = Entidad::with('inversiones')
    ->findOrFail($id);

if(!$this->puedeEditarEntidad($entidad))
{
    abort(403);
}

        $entidad = Entidad::findOrFail($id);

        return view(
            'entidades.edit',
            compact('entidad')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
       $entidad = Entidad::with('inversiones')
    ->findOrFail($id);

if(!$this->puedeEditarEntidad($entidad))
{
    abort(403);
}

        $data = $request->all();

        $data['es_entidad'] = $request->has('es_entidad');
        $data['es_apnfd'] = $request->has('es_apnfd');

        $entidad->update($data);

        return redirect('/entidades')
            ->with(
                'success',
                'Entidad actualizada'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
public function destroy(Request $request, $id)
{
    if(auth()->user()->role != 'admin')
    {
        abort(403);
    }

    $entidad = Entidad::findOrFail($id);

    $entidad->delete();

    if($request->filled('inversion_id'))
    {
        return redirect(
            '/inversiones/' .
            $request->inversion_id .
            '/entidades'
        )->with(
            'success',
            'Entidad eliminada'
        );
    }

    return redirect('/entidades')
        ->with(
            'success',
            'Entidad eliminada'
        );
}

private function puedeEditarEntidad($entidad)
{
    if(auth()->user()->role == 'admin')
    {
        return true;
    }

    foreach($entidad->inversiones as $inversion)
    {
        if(
            auth()->user()->tienePermiso(
                $inversion->id,
                'entidades'
            )
        )
        {
            return true;
        }
    }

    return false;
}
}