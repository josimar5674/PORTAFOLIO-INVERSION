<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entidad;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

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
        ) {
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
    $usuario = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    if ($usuario->role === 'admin') {

        $entidades = Entidad::orderBy(
            'denominacion_social'
        )->get();

    } else {

        /*
        |--------------------------------------------------------------------------
        | SOLO ENTIDADES AUTORIZADAS
        |--------------------------------------------------------------------------
        */

        $entidades = $usuario->entidades()
            ->orderBy('denominacion_social')
            ->get();

    }

    /*
    |--------------------------------------------------------------------------
    | SIN INVERSIÓN ESPECÍFICA
    |--------------------------------------------------------------------------
    */

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
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $clientes = Cliente::orderBy('nombre')->get();

        return view('entidades.create', compact('clientes'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {


        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $data = $request->all();

        $data['es_entidad'] = $request->has('es_entidad');
        $data['es_apnfd'] = $request->has('es_apnfd');

        $entidad = Entidad::create($data);

        // Validar que existan socios

        if (empty($request->socios)) {
            return back()
                ->withInput()
                ->withErrors([
                    'socios' => 'Debe ingresar al menos un socio.'
                ]);
        }

        $total = collect($request->socios)
            ->sum(fn($s) => (float)$s['porcentaje']);

        if (abs($total - 100) > 0.01) {
            return back()
                ->withInput()
                ->withErrors([
                    'socios' => 'La suma de los porcentajes debe ser exactamente 100%.'
                ]);
        }

        $sync = [];

        foreach ($request->socios as $socio) {
            $sync[$socio['cliente_id']] = [
                'porcentaje' => $socio['porcentaje']
            ];
        }

        $entidad->socios()->sync($sync);

        return redirect(
            "/entidades/{$entidad->id}/edit"
        )->with(
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
        $entidad = Entidad::with([
            'inversiones',
            'socios'
        ])->findOrFail($id);

        if (!$this->puedeEditarEntidad($entidad)) {
            abort(403);
        }

        $clientes = Cliente::orderBy('nombre')->get();

        $sociosActuales = old(
            'socios',
            $entidad->socios->map(function ($socio) {

                return [
                    'cliente_id' => $socio->id,
                    'porcentaje' => $socio->pivot->porcentaje,
                ];
            })->values()
        );

        return view(
            'entidades.edit',
            compact(
                'entidad',
                'clientes',
                'sociosActuales'
            )
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

        if (!$this->puedeEditarEntidad($entidad)) {
            abort(403);
        }

        $data = $request->all();

        $data['es_entidad'] = $request->has('es_entidad');
        $data['es_apnfd'] = $request->has('es_apnfd');

        $entidad->update($data);

        if (empty($request->socios)) {
            return back()
                ->withInput()
                ->withErrors([
                    'socios' => 'Debe ingresar al menos un socio.'
                ]);
        }

        $total = collect($request->socios)
            ->sum(fn($s) => (float)$s['porcentaje']);

        if (abs($total - 100) > 0.01) {
            return back()
                ->withInput()
                ->withErrors([
                    'socios' => 'La suma debe ser 100%.'
                ]);
        }

        $sync = [];

        foreach ($request->socios as $socio) {
            $sync[$socio['cliente_id']] = [
                'porcentaje' => $socio['porcentaje']
            ];
        }

        $entidad->socios()->sync($sync);

    return redirect("/entidades/{$entidad->id}/edit")
    ->with(
        'success',
        'Entidad actualizada correctamente.'
    );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(Request $request, $id)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $entidad = Entidad::findOrFail($id);

        $entidad->delete();

        if ($request->filled('inversion_id')) {
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
    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    if (auth()->user()->role === 'admin') {
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | ENTIDAD AUTORIZADA
    |--------------------------------------------------------------------------
    */

    return DB::table('user_entidad')
        ->where('user_id', auth()->id())
        ->where('entidad_id', $entidad->id)
        ->exists();
}
}
