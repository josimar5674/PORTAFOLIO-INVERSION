<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessCustomer;

class BusinessCustomerController extends Controller
{
    public function index()
    {
        $clientes = BusinessCustomer::orderBy(
            'nombre'
        )->get();

        return view(
            'business_customers.index',
            compact('clientes')
        );
    }

    public function create()
    {
        return view(
            'business_customers.create'
        );
    }

public function store(Request $request)
{
    $request->validate([

        'nombre' => 'required',

        'identificador_tributario'
            => 'nullable',

        'email'
            => 'nullable|email',

        'telefono'
            => 'nullable',

    ]);

    $cliente = BusinessCustomer::create([

        'nombre'
            => $request->nombre,

        'identificador_tributario'
            => $request->identificador_tributario,

        'email'
            => $request->email,

        'telefono'
            => $request->telefono,

    ]);

    foreach($request->notas ?? [] as $nota)
    {
        $cliente->notas()->create([

            'nota' => $nota

        ]);
    }

    return redirect(
        '/business-customers'
    )->with(
        'success',
        'Cliente creado correctamente'
    );
}
    public function edit($id)
    {
        $cliente =
            BusinessCustomer::findOrFail(
                $id
            );

        return view(
            'business_customers.edit',
            compact('cliente')
        );
    }

   public function update(
    Request $request,
    $id
)
{
    $request->validate([

        'nombre' => 'required',

        'identificador_tributario'
            => 'nullable',

        'email'
            => 'nullable|email',

        'telefono'
            => 'nullable',

    ]);

    $cliente =
        BusinessCustomer::findOrFail(
            $id
        );

    $cliente->update([

        'nombre'
            => $request->nombre,

        'identificador_tributario'
            => $request->identificador_tributario,

        'email'
            => $request->email,

        'telefono'
            => $request->telefono,

    ]);

    $cliente->notas()->delete();

    foreach($request->notas ?? [] as $nota)
    {
        $cliente->notas()->create([

            'nota' => $nota

        ]);
    }

    return redirect(
        '/business-customers'
    )->with(
        'success',
        'Cliente actualizado'
    );
}
    public function destroy($id)
    {
        $cliente =
            BusinessCustomer::findOrFail(
                $id
            );

        $cliente->delete();

        return redirect(
            '/business-customers'
        )->with(
            'success',
            'Cliente eliminado'
        );
    }
}