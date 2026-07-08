<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Inversion;

class AssetController extends Controller
{
    public function index($investment_id = null)
    {
        $inversion = null;

        if ($investment_id) {

            $inversion = Inversion::findOrFail($investment_id);

            $assets = Asset::where(
                'investment_id',
                $investment_id
            )->get();

        } else {

            $assets = Asset::with('inversion')->get();

        }

        return view(
            'assets.index',
            compact(
                'assets',
                'inversion'
            )
        );
    }

    public function create($investment_id)
    {
        return view(
            'assets.create',
            compact('investment_id')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'investment_id' => 'required|exists:inversiones,id',

            'name' => 'required|string|max:255',

            'category' => 'required|string|max:255',

            'brand' => 'nullable|string|max:255',

            'model' => 'nullable|string|max:255',

            'serial_number' => 'nullable|string|max:255',

            'asset_code' => 'nullable|string|max:255',

            'purchase_date' => 'nullable|date',

            'purchase_value' => 'nullable|numeric',

            'useful_life' => 'nullable|integer',

            'description' => 'nullable|string',

            'status' => 'required|boolean',

        ]);

        Asset::create([

            'investment_id' => $request->investment_id,

            'name' => $request->name,

            'category' => $request->category,

            'brand' => $request->brand,

            'model' => $request->model,

            'serial_number' => $request->serial_number,

            'asset_code' => $request->asset_code,

            'purchase_date' => $request->purchase_date,

            'purchase_value' => $request->purchase_value,

            'useful_life' => $request->useful_life,

            'description' => $request->description,

            'status' => $request->status,

        ]);

        return redirect(
            "/inversiones/{$request->investment_id}/assets"
        )->with(
            'success',
            'Activo creado correctamente.'
        );
    }

    public function edit($investment_id, $id)
    {
        $asset = Asset::findOrFail($id);

        return view(
            'assets.edit',
            compact(
                'asset',
                'investment_id'
            )
        );
    }

    public function update(Request $request, $investment_id, $id)
    {
        $request->validate([

            'name' => 'required|string|max:255',

            'category' => 'required|string|max:255',

            'brand' => 'nullable|string|max:255',

            'model' => 'nullable|string|max:255',

            'serial_number' => 'nullable|string|max:255',

            'asset_code' => 'nullable|string|max:255',

            'purchase_date' => 'nullable|date',

            'purchase_value' => 'nullable|numeric',

            'useful_life' => 'nullable|integer',

            'description' => 'nullable|string',

            'status' => 'required|boolean',

        ]);

        $asset = Asset::findOrFail($id);

        $asset->update([

            'name' => $request->name,

            'category' => $request->category,

            'brand' => $request->brand,

            'model' => $request->model,

            'serial_number' => $request->serial_number,

            'asset_code' => $request->asset_code,

            'purchase_date' => $request->purchase_date,

            'purchase_value' => $request->purchase_value,

            'useful_life' => $request->useful_life,

            'description' => $request->description,

            'status' => $request->status,

        ]);

        return redirect(
            "/inversiones/{$investment_id}/assets"
        )->with(
            'success',
            'Activo actualizado correctamente.'
        );
    }

  public function destroy($investment_id, $id)
{
    $asset = Asset::findOrFail($id);

    $asset->delete();

    return redirect(
        "/inversiones/{$investment_id}/assets"
    )->with(
        'success',
        'Activo eliminado correctamente.'
    );
}
}