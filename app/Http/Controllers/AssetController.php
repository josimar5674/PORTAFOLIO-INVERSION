<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;

class AssetController extends Controller
{
  public function index($investment_id = null)
{
    if ($investment_id) {
        $assets = Asset::where('investment_id', $investment_id)->get();
    } else {
        $assets = Asset::with('inversion')->get(); // importante
    }

    return view('assets.index', compact('assets', 'investment_id'));
}

    public function create($investment_id)
    {
        return view('assets.create', compact('investment_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'investment_id' => 'required|exists:inversiones,id',
            'name' => 'required',
        ]);

        Asset::create($request->all());

        return redirect('/inversiones/' . $request->investment_id . '/assets')
            ->with('success', 'Activo creado correctamente');
    }

public function edit($investment_id, $id)
{
    $asset = Asset::findOrFail($id);

    return view('assets.edit', compact(
        'asset',
        'investment_id'
    ));
}

public function update(Request $request, $investment_id, $id)
{
    $request->validate([
        'name' => 'required',
    ]);

    $asset = Asset::findOrFail($id);

    $asset->update($request->all());

    return redirect('/inversiones/' . $investment_id . '/assets')
        ->with('success', 'Activo actualizado');
}
    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $investment_id = $asset->investment_id;

        $asset->delete();

        return redirect('/inversiones/' . $investment_id . '/assets')
            ->with('success', 'Activo eliminado');
    }
}