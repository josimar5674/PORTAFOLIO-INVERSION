<?php

namespace App\Http\Controllers;

use App\Models\Inversion;

class BitacoraController extends Controller
{
    public function index(Inversion $inversion)
    {
        if (
            !auth()->user()->tienePermiso(
                $inversion->id,
                'bitacoras'
            )
        ) {
            abort(403);
        }

        return view(
            'bitacoras.index',
            compact('inversion')
        );
    }
}