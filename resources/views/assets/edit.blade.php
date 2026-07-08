@extends('layouts.app')

@section('content')


<style>
    .card-seccion {
        background: var(--surface);
        padding: 18px;
        border-radius: 12px;
        margin-bottom: 18px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
    }

    .card-seccion h4 {
        margin-bottom: 12px;
        font-weight: 600;
        color: var(--text);
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    input,
    select,
    textarea {

        width: 100%;
        padding: 10px;
        border: 1px solid var(--border);
        border-radius: 8px;
        background: var(--surface);
        color: var(--text);
        box-sizing: border-box;

    }

    input:focus,
    select:focus,
    textarea:focus {

        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 2px rgba(234, 207, 51, .20);

    }

    label {

        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: var(--text);

    }

    Select {
        max-width: 100%;
        height: 35px;
        border-radius: 10px;

    }
</style>




    <!-- 🔙 VOLVER -->
    <div style="margin-bottom:10px;">
        <a href="/inversiones/{{ $asset->investment_id }}/assets" class="btn-secondary">
            ← Volver a Activos
        </a>
    </div>

    <div class="form-title">✏️ Editar Activo</div>

    @if ($errors->any())
    <div class="error-box">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST"
        action="/inversiones/{{ $asset->investment_id }}/assets/{{ $asset->id }}">

        @csrf
        @method('PUT')

        <input
            type="hidden"
            name="investment_id"
            value="{{ $asset->investment_id }}">

        <!-- ===================================== -->
        <!-- INFORMACIÓN GENERAL -->
        <!-- ===================================== -->

        <div class="card-seccion">

            <h4>📋 Información General</h4>

            <div class="grid-2">

                <div>

                    <label>Nombre del Activo</label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name',$asset->name) }}">

                </div>

                <div>

                    <label>Categoría</label>

                    <select name="category">

                        <option value="">Seleccione...</option>

                        <option value="Vehículo"
                            {{ old('category',$asset->category)=='Vehículo'?'selected':'' }}>
                            🚗 Vehículo
                        </option>

                        <option value="Equipo Informático"
                            {{ old('category',$asset->category)=='Equipo Informático'?'selected':'' }}>
                            💻 Equipo Informático
                        </option>

                        <option value="Equipo de Oficina"
                            {{ old('category',$asset->category)=='Equipo de Oficina'?'selected':'' }}>
                            🖨️ Equipo de Oficina
                        </option>

                        <option value="Mobiliario"
                            {{ old('category',$asset->category)=='Mobiliario'?'selected':'' }}>
                            🪑 Mobiliario
                        </option>

                        <option value="Maquinaria"
                            {{ old('category',$asset->category)=='Maquinaria'?'selected':'' }}>
                            🏗️ Maquinaria
                        </option>

                        <option value="Herramienta"
                            {{ old('category',$asset->category)=='Herramienta'?'selected':'' }}>
                            🛠️ Herramienta
                        </option>

                        <option value="Electrodoméstico"
                            {{ old('category',$asset->category)=='Electrodoméstico'?'selected':'' }}>
                            📺 Electrodoméstico
                        </option>

                        <option value="Otro"
                            {{ old('category',$asset->category)=='Otro'?'selected':'' }}>
                            📦 Otro
                        </option>

                    </select>

                </div>

                <div>

                    <label>Marca</label>

                    <input
                        type="text"
                        name="brand"
                        value="{{ old('brand',$asset->brand) }}">

                </div>

                <div>

                    <label>Modelo</label>

                    <input
                        type="text"
                        name="model"
                        value="{{ old('model',$asset->model) }}">

                </div>

            </div>

        </div>


<div class="card-seccion">

    <h4>🏷️ Identificación</h4>

    <div class="grid-2">

        <div>

            <label>Código del Activo</label>

            <input
                type="text"
                name="asset_code"
                value="{{ old('asset_code',$asset->asset_code) }}">

        </div>

        <div>

            <label>Número de Serie</label>

            <input
                type="text"
                name="serial_number"
                value="{{ old('serial_number',$asset->serial_number) }}">

        </div>

        <div>

            <label>Estado</label>

            <select name="status">

                <option value="1"
                    {{ old('status',$asset->status)==1?'selected':'' }}>
                    Activo
                </option>

                <option value="0"
                    {{ old('status',$asset->status)==0?'selected':'' }}>
                    Inactivo
                </option>

            </select>

        </div>

    </div>

</div>

<div class="card-seccion">

    <h4>💰 Información Financiera</h4>

    <div class="grid-2">

        <div>

            <label>Fecha de Compra</label>

            <input
                type="date"
                name="purchase_date"
                value="{{ old('purchase_date',$asset->purchase_date) }}">

        </div>

        <div>

            <label>Valor de Compra $</label>

            <input
                type="number"
                step="0.01"
                name="purchase_value"
                value="{{ old('purchase_value',$asset->purchase_value) }}">

        </div>

        <div>

            <label>Vida Útil (años)</label>

            <input
                type="number"
                name="useful_life"
                value="{{ old('useful_life',$asset->useful_life) }}">

        </div>

    </div>

</div>

<div class="card-seccion">

    <h4>📝 Observaciones</h4>

    <label>Descripción</label>

    <textarea
        name="description"
        rows="5">{{ old('description',$asset->description) }}</textarea>

</div>



<div style="margin-top:25px; display:flex; gap:10px;">

    <button
        type="submit"
        class="btn-primary-custom">

        💾 Actualizar Activo

    </button>

    <a
        href="/inversiones/{{ $asset->investment_id }}/assets"
        class="btn-secondary">

        Cancelar

    </a>

</div>



</form>

<hr>

@include('components.notes',[
    'modelo' => $asset,
    'modelClass' => 'App\Models\Asset'
])  

<hr>

@include('components.documents',[
    'modelo' => $asset,
    'modelClass' => 'App\Models\Asset'
])

@endsection