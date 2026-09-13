<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenController extends Controller
{
    public function store(Request $request)
    {

          if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'imagenes' => 'required|array',
            'imagenes.*' => 'image|mimes:jpg,jpeg,png,webp|max:10240',

            'imageable_type' => 'required|string',
            'imageable_id' => 'required|integer',

            'descripcion' => 'nullable|string|max:1000',
        ]);

        $modelo = $request->imageable_type::findOrFail(
            $request->imageable_id
        );

        foreach ($request->file('imagenes') as $imagen) {

            $ruta = $imagen->store(
                'imagenes',
                'public'
            );

            $modelo->imagenes()->create([
                'ruta' => $ruta,
                'nombre_original' => $imagen->getClientOriginalName(),
                'descripcion' => $request->descripcion,
                'orden' => 0,
            ]);
        }

        return back()->with(
            'success',
            'Imágenes agregadas correctamente.'
        );
    }

    public function destroy(Imagen $imagen)
    {

         if (auth()->user()->role !== 'admin') {

        abort(403);

    }
        Storage::disk('public')->delete(
            $imagen->ruta
        );

        $imagen->delete();

        return back()->with(
            'success',
            'Imagen eliminada correctamente.'
        );
    }
}