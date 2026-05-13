<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        return view('usuarios.create');
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

        User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'role' => $request->role,

            'estado' => $request->estado,

        ]);

        return redirect('/usuarios')
            ->with('success', 'Usuario creado correctamente');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $usuario = User::findOrFail($id);

        return view('usuarios.edit', compact('usuario'));
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

        return redirect('/usuarios')
            ->with('success', 'Usuario actualizado');
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