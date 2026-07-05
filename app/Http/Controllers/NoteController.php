<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'note' => 'required',
            'notable_type' => 'required',
            'notable_id' => 'required',
        ]);

        $modelo = $request->notable_type::findOrFail(
            $request->notable_id
        );

        $modelo->notas()->create([
            'note' => $request->note
        ]);

        return back()->with(
            'success',
            'Nota agregada correctamente.'
        );
    }

    public function destroy($id)
    {
        $nota = Note::findOrFail($id);

        $nota->delete();

        return back()->with(
            'success',
            'Nota eliminada correctamente.'
        );
    }
}