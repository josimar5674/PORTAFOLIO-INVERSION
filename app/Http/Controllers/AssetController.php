<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Inversion;
use App\Models\Comercial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    public function index(Request $request, $investment_id = null)
{
    $inversion = null;

    /*
    |--------------------------------------------------------------------------
    | UBICACIÓN SELECCIONADA
    |--------------------------------------------------------------------------
    */
$sessionKey = 'assets_producto_id_' . $investment_id;

if ($request->has('producto_id')) {

    if ($request->producto_id !== '') {

        session([
            $sessionKey => $request->producto_id
        ]);

    } else {

        session()->forget($sessionKey);

    }

}

$productoId = session($sessionKey);


    /*
    |--------------------------------------------------------------------------
    | ACTIVOS
    |--------------------------------------------------------------------------
    */

    if ($investment_id) {

        $inversion = Inversion::findOrFail(
            $investment_id
        );

        $query = Asset::with('producto')
            ->where(
                'investment_id',
                $investment_id
            );

    } else {

        $query = Asset::with('producto');

    }


    /*
    |--------------------------------------------------------------------------
    | FILTRAR POR UBICACIÓN
    |--------------------------------------------------------------------------
    */

    if ($productoId) {

        $query->where(
            'producto_id',
            $productoId
        );

    }


    $assets = $query->get();


    /*
    |--------------------------------------------------------------------------
    | UBICACIONES
    |--------------------------------------------------------------------------
    */

   $ubicaciones = collect();

if ($investment_id) {

    $productoIds = Asset::where(
        'investment_id',
        $investment_id
    )
    ->whereNotNull('producto_id')
    ->distinct()
    ->pluck('producto_id');

    $ubicaciones = \App\Models\Comercial::whereIn(
        'id',
        $productoIds
    )
    ->orderBy('producto')
    ->get();
}


    return view(
        'assets.index',
        compact(
            'assets',
            'inversion',
            'ubicaciones',
            'productoId'
        )
    );
}

public function create($investment_id)
{
    $inversion = Inversion::findOrFail($investment_id);

    $ubicaciones = Comercial::where(
        'inversion_id',
        $investment_id
    )
    ->orderBy('producto')
    ->get();

    return view(
        'assets.create',
        compact(
            'investment_id',
            'ubicaciones'
        )
    );
}

    public function store(Request $request)
    {

        $request->validate([

            'investment_id' => 'required|exists:inversiones,id',

            'name' => 'required|string|max:255',


            'producto_id' => 'nullable|exists:comercial,id',
            'category' => 'required|string|max:255',

            'brand' => 'nullable|string|max:255',

            'model' => 'nullable|string|max:255',

            'serial_number' => 'nullable|string|max:255',

            'asset_code' => 'nullable|string|max:255',

            'purchase_date' => 'nullable|date',

            'purchase_value' => 'nullable|numeric',

            'sale_value' => 'nullable|numeric',

            'useful_life' => 'nullable|integer',

            'description' => 'nullable|string',

            'status' => 'required|boolean',


        ]);

        Asset::create([

            'investment_id' => $request->investment_id,

            'name' => $request->name,

            'producto_id' => $request->producto_id,

            'category' => $request->category,

            'brand' => $request->brand,

            'model' => $request->model,

            'serial_number' => $request->serial_number,

            'asset_code' => $request->asset_code,

            'purchase_date' => $request->purchase_date,

            'purchase_value' => $request->purchase_value,

            'sale_value' => $request->sale_value,

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

    $ubicaciones = Comercial::where(
        'inversion_id',
        $investment_id
    )
    ->orderBy('producto')
    ->get();

    return view(
        'assets.edit',
        compact(
            'asset',
            'investment_id',
            'ubicaciones'
        )
    );
}

    public function update(Request $request, $investment_id, $id)
    {
        $request->validate([

            'name' => 'required|string|max:255',

            'producto_id' => 'nullable|string|max:255',

            'category' => 'required|string|max:255',

            'brand' => 'nullable|string|max:255',

            'model' => 'nullable|string|max:255',

            'serial_number' => 'nullable|string|max:255',

            'asset_code' => 'nullable|string|max:255',

            'purchase_date' => 'nullable|date',

            'purchase_value' => 'nullable|numeric',

            'sale_value' => 'nullable|numeric',

            'useful_life' => 'nullable|integer',

            'description' => 'nullable|string',

            'status' => 'required|boolean',


        ]);

        $asset = Asset::findOrFail($id);

        $asset->update([

            'name' => $request->name,

            'producto_id' => $request->producto_id,

            'category' => $request->category,

            'brand' => $request->brand,

            'model' => $request->model,

            'serial_number' => $request->serial_number,

            'asset_code' => $request->asset_code,

            'purchase_date' => $request->purchase_date,

            'purchase_value' => $request->purchase_value,

            'sale_value' => $request->sale_value,

            'useful_life' => $request->useful_life,

            'description' => $request->description,

            'status' => $request->status,

        ]);

        return back()->with(
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


    public function duplicate(Request $request, $investment_id, $id)
{
    $request->validate([

        'quantity' => 'required|integer|min:1|max:500',

    ]);

    $asset = Asset::where('investment_id', $investment_id)
        ->findOrFail($id);

    DB::transaction(function () use ($asset, $request) {

        for ($i = 0; $i < $request->quantity; $i++) {

            $duplicado = $asset->replicate();

            /*
            |--------------------------------------------------------------------------
            | Identificador temporal
            |--------------------------------------------------------------------------
            */

            $duplicado->asset_code =
                'DUP-' .
                $asset->id .
                '-' .
                strtoupper(Str::random(6));


            /*
            |--------------------------------------------------------------------------
            | El número de serie no se duplica
            |--------------------------------------------------------------------------
            */

            $duplicado->serial_number = null;


            /*
            |--------------------------------------------------------------------------
            | Guardar
            |--------------------------------------------------------------------------
            */

            $duplicado->save();

        }

    });

    return redirect(
        "/inversiones/{$investment_id}/assets"
    )->with(
        'success',
        $request->quantity .
        ' activo(s) duplicado(s) correctamente.'
    );
}
}
