<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entidad;

class EntidadController extends Controller
{
   public function index()

{

    $entidades = Entidad::all();

    return view('entidades.index', compact('entidades'));

}

 public function create()

{

    return view('entidades.create');

}

    public function store(Request $request)
    {
        $data = $request->all();

    

        $data['es_entidad'] = $request->has('es_entidad');
        $data['es_apnfd'] = $request->has('es_apnfd');

        Entidad::create($data);

return redirect('/entidades')
    ->with('success', 'Entidad creada correctamente');
          
    }

   public function edit($id)
{
    $entidad = Entidad::findOrFail($id);

    return view('entidades.edit', compact('entidad'));
}

public function update(Request $request, $id)
{
    $entidad = Entidad::findOrFail($id);

    $data = $request->all();

    $data['es_entidad'] = $request->has('es_entidad');
    $data['es_apnfd'] = $request->has('es_apnfd');

    $entidad->update($data);

    return redirect('/entidades')
        ->with('success', 'Entidad actualizada');
}

  public function destroy($id)
    {
        $entidad = Entidad::findOrFail($id);

        $entidad->delete();

    return redirect('/entidades')
    ->with('success', 'Entidad eliminada');
    }

    public function porInversion($id)
{
    $inversion = \App\Models\Inversion::with('entidades')
        ->findOrFail($id);

    $entidades = $inversion->entidades;

    return view('entidades.index', compact(
        'entidades',
        'inversion'
    ));
}
}
