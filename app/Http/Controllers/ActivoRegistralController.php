<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivoRegistral;
use App\Models\InscripcionActivo;
use App\Models\Inversion;

class ActivoRegistralController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index($inversionId)
    {
        $inversion = Inversion::findOrFail($inversionId);

        $activos = ActivoRegistral::with('inscripciones')
            ->where('inversion_id', $inversionId)
            ->get();

        return view('activos_registrales.index', compact(
            'activos',
            'inversion'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create($inversionId)
    {
        $inversion = Inversion::findOrFail($inversionId);

        return view('activos_registrales.create', compact(
            'inversion'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, $inversionId)
    {
        $activo = ActivoRegistral::create([

            'inversion_id' => $inversionId,

            'ubicacion_inmueble' =>
                $request->ubicacion_inmueble,

            'ciudad' =>
                $request->ciudad,

            'numero_matricula' =>
                $request->numero_matricula,

            'valor_escrituracion' =>
                $request->valor_escrituracion,

            'clave_catastral_ip' =>
                $request->clave_catastral_ip,

            'clave_catastral_municipal' =>
                $request->clave_catastral_municipal,

            'zonificacion' =>
                $request->zonificacion,

            'digitalizacion' =>
                $request->digitalizacion,
        ]);

        /*
        |--------------------------------------------------------------------------
        | GUARDAR INSCRIPCIONES
        |--------------------------------------------------------------------------
        */

        if ($request->fecha) {

            foreach ($request->fecha as $i => $fecha) {

                if (
                    !$fecha &&
                    empty($request->acto[$i]) &&
                    empty($request->inscripcion[$i])
                ) {
                    continue;
                }

                InscripcionActivo::create([

                    'activo_registral_id' => $activo->id,

                    'fecha' =>
                        $request->fecha[$i] ?? null,

                    'acto' =>
                        $request->acto[$i] ?? null,

                    'inscripcion' =>
                        $request->inscripcion[$i] ?? null,

                    'descripcion' =>
                        $request->descripcion[$i] ?? null,

                    'digitalizacion' =>
                        $request->digitalizacion_inscripcion[$i] ?? null,
                ]);
            }
        }

        return redirect(
            "/inversiones/$inversionId/activos-registrales"
        )->with(
            'success',
            'Activo registral creado correctamente.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $activo = ActivoRegistral::with('inscripciones')
            ->findOrFail($id);

        return view('activos_registrales.edit', compact(
            'activo'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
public function update(Request $request, $id)
{
    $activo = ActivoRegistral::with('inscripciones')
        ->findOrFail($id);

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR ACTIVO
    |--------------------------------------------------------------------------
    */

    $activo->update([

        'ubicacion_inmueble' =>
            $request->ubicacion_inmueble,

        'ciudad' =>
            $request->ciudad,

        'numero_matricula' =>
            $request->numero_matricula,

        'valor_escrituracion' =>
            $request->valor_escrituracion,

        'clave_catastral_ip' =>
            $request->clave_catastral_ip,

        'clave_catastral_municipal' =>
            $request->clave_catastral_municipal,

        'zonificacion' =>
            $request->zonificacion,

        'digitalizacion' =>
            $request->digitalizacion,
    ]);

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR INSCRIPCIONES VIEJAS
    |--------------------------------------------------------------------------
    */

    $activo->inscripciones()->delete();

    /*
    |--------------------------------------------------------------------------
    | CREAR INSCRIPCIONES NUEVAS
    |--------------------------------------------------------------------------
    */

    if ($request->fecha) {

        foreach ($request->fecha as $i => $fecha) {

            if (
                !$fecha &&
                empty($request->acto[$i]) &&
                empty($request->inscripcion[$i])
            ) {
                continue;
            }

            InscripcionActivo::create([

                'activo_registral_id' =>
                    $activo->id,

                'fecha' =>
                    $request->fecha[$i] ?? null,

                'acto' =>
                    $request->acto[$i] ?? null,

                'inscripcion' =>
                    $request->inscripcion[$i] ?? null,

                'descripcion' =>
                    $request->descripcion[$i] ?? null,

                'digitalizacion' =>
                    $request->digitalizacion_inscripcion[$i] ?? null,
            ]);
        }
    }

    return redirect(
        "/inversiones/{$activo->inversion_id}/activos-registrales"
    )->with(
        'success',
        'Activo registral actualizado correctamente.'
    );
}

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $activo = ActivoRegistral::findOrFail($id);

        $inversionId = $activo->inversion_id;

        $activo->delete();

        return redirect(
            "/inversiones/$inversionId/activos-registrales"
        )->with(
            'success',
            'Activo registral eliminado.'
        );
    }
}