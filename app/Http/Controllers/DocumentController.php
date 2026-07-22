<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;


class DocumentController extends Controller
{
    public function store(Request $request)
{
    $request->validate([

        'documentable_type' => 'required',

        'documentable_id' => 'required',

        'archivo' => 'required|file|mimes:pdf|max:102400',

        'nombre' => 'required'

    ]);

    $modelo =
        $request->documentable_type::findOrFail(
            $request->documentable_id
        );

    $ruta = $request
        ->file('archivo')
        ->store(
            'documentos',
            'public'
        );

    $modelo->documentos()->create([

        'nombre' => $request->nombre,

        'archivo' => $ruta,

        'tipo' => 'PDF',

        'descripcion' =>
            $request->descripcion

    ]);

    return back()
        ->with(
            'success',
            'Documento cargado'
        );
}

public function destroy($id)
{
    $documento =
        Document::findOrFail($id);

    $documento->delete();

    return back();
}
}
