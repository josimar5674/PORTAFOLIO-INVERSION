<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Inversion;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{



    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $usuarios = User::all();

        return view('usuarios.index', compact('usuarios'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

public function create()
{
    $inversiones = Inversion::all();

    return view(
        'usuarios.create',
        compact('inversiones')
    );
}

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

public function store(Request $request)
{
    $request->validate([

        'name' => 'required',

        'email' => 'required|email|unique:users,email',

        'password' => 'required|min:6',

        'role' => 'required',

        'estado' => 'required',

    ]);

    $usuario = User::create([

        'name' => $request->name,

        'email' => $request->email,

        'password' => Hash::make($request->password),

        'role' => $request->role,

        'estado' => $request->estado,

    ]);

    /*
    |--------------------------------------------------------------------------
    | Si es usuario normal, guardar permisos
    |--------------------------------------------------------------------------
    */
    if (
        $request->role == 'user'
        &&
        $request->has('inversiones')
    )
    {
        foreach ($request->inversiones as $inversionId)
        {
            /*
            |--------------------------------------------------------------------------
            | Relación Usuario - Inversión
            |--------------------------------------------------------------------------
            */
            DB::table('user_inversion')->insert([

                'user_id' => $usuario->id,

                'inversion_id' => $inversionId,

                'created_at' => now(),

                'updated_at' => now(),

            ]);

            /*
            |--------------------------------------------------------------------------
            | Permisos por módulo
            |--------------------------------------------------------------------------
            */
            DB::table('user_inversion_modulos')->insert([

                'user_id' => $usuario->id,

                'inversion_id' => $inversionId,

                'avaluos' =>
                    isset($request->permisos[$inversionId]['avaluos']),

                'activos' =>
                    isset($request->permisos[$inversionId]['activos']),

                'servicios' =>
                    isset($request->permisos[$inversionId]['servicios']),

                'comercial' =>
                    isset($request->permisos[$inversionId]['comercial']),

                'entidades' =>
                    isset($request->permisos[$inversionId]['entidades']),

                'estado_resultados' =>
                    isset($request->permisos[$inversionId]['estado_resultados']),

                'activos_registrales' =>
    isset($request->permisos[$inversionId]['activos_registrales']),

                'created_at' => now(),

                'updated_at' => now(),

            ]);
        }
    }

    return redirect('/usuarios')
        ->with(
            'success',
            'Usuario creado correctamente'
        );
}

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

public function edit($id)
{
    $usuario = User::findOrFail($id);

    $inversiones = \App\Models\Inversion::all();

    $permisos = \DB::table('user_inversion_modulos')
        ->where('user_id', $usuario->id)
        ->get()
        ->keyBy('inversion_id');

    $inversionesUsuario = \DB::table('user_inversion')
        ->where('user_id', $usuario->id)
        ->pluck('inversion_id')
        ->toArray();

    return view(
        'usuarios.edit',
        compact(
            'usuario',
            'inversiones',
            'permisos',
            'inversionesUsuario'
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
    $usuario = User::findOrFail($id);

    $request->validate([

        'email' => 'required|email',

        'role' => 'required',

        'estado' => 'required',

    ]);

    $usuario->email = $request->email;

    $usuario->role = $request->role;

    $usuario->estado = $request->estado;

    $usuario->save();

    /*
    |--------------------------------------------------------------------------
    | Limpiar permisos anteriores
    |--------------------------------------------------------------------------
    */
    DB::table('user_inversion')
        ->where('user_id', $usuario->id)
        ->delete();

    DB::table('user_inversion_modulos')
        ->where('user_id', $usuario->id)
        ->delete();

    /*
    |--------------------------------------------------------------------------
    | Guardar permisos nuevos
    |--------------------------------------------------------------------------
    */
    if (
        $request->role == 'user'
        &&
        $request->has('inversiones')
    )
    {
        foreach ($request->inversiones as $inversionId)
        {
            DB::table('user_inversion')->insert([

                'user_id' => $usuario->id,

                'inversion_id' => $inversionId,

                'created_at' => now(),

                'updated_at' => now(),

            ]);

            DB::table('user_inversion_modulos')->insert([

                'user_id' => $usuario->id,

                'inversion_id' => $inversionId,

                'avaluos' =>
                    isset($request->permisos[$inversionId]['avaluos']),

                'activos' =>
                    isset($request->permisos[$inversionId]['activos']),

                'servicios' =>
                    isset($request->permisos[$inversionId]['servicios']),

                'comercial' =>
                    isset($request->permisos[$inversionId]['comercial']),

                'entidades' =>
                    isset($request->permisos[$inversionId]['entidades']),
'estado_resultados' =>
    isset($request->permisos[$inversionId]['estado_resultados']),

'activos_registrales' =>
    isset($request->permisos[$inversionId]['activos_registrales']),

'created_at' => now(),

'updated_at' => now(),


            ]);
        }
    }

    return redirect('/usuarios')
        ->with(
            'success',
            'Usuario actualizado correctamente'
        );
}

    /*
    |--------------------------------------------------------------------------
    | DESHABILITAR
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        $usuario->estado = false;

        $usuario->save();

        return redirect('/usuarios')
            ->with('success', 'Usuario deshabilitado');
    }
}