@extends('layouts.app')

@section('content')

<style>

.card-seccion{
    background:var(--surface);
    padding:18px;
    border-radius:12px;
    margin-bottom:18px;
    box-shadow:var(--shadow);
    border:1px solid var(--border);
}

.card-seccion h4{
    margin-bottom:12px;
    font-weight:600;
    color:var(--text);
}

.grid-2{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
}

input,
select,
textarea{

    width:100%;
    padding:10px;
    border:1px solid var(--border);
    border-radius:8px;
    background:var(--surface);
    color:var(--text);
    box-sizing:border-box;

}

input:focus,
select:focus,
textarea:focus{

    border-color:var(--primary);
    outline:none;
    box-shadow:0 0 0 2px rgba(234,207,51,.20);

}

label{

    display:block;
    margin-bottom:6px;
    font-weight:600;
    color:var(--text);

}

Select{

    width:220px;
    max-width:100%;
    height: 35px;
    border-radius: 10px;

}

</style>

<!-- ===================================== -->
<!-- INFORMACIÓN GENERAL -->
<!-- ===================================== -->
<form method="POST"
      action="/inversiones/{{ $investment_id }}/assets">

    @csrf

    <input
        type="hidden"
        name="investment_id"
        value="{{ $investment_id }}">


<div class="card-seccion">

    <h4>📋 Información General</h4>

    <div class="grid-2">

        <div>
            <label>Nombre del Activo</label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Ej. Toyota Hilux 2024">
        </div>

        <div>
            <label>Categoría</label>

            <select name="category">

                <option value="">Seleccione...</option>

                <option value="Vehículo">🚗 Vehículo</option>
                <option value="Equipo Informático">💻 Equipo Informático</option>
                <option value="Equipo de Oficina">🖨️ Equipo de Oficina</option>
                <option value="Mobiliario">🪑 Mobiliario</option>
                <option value="Maquinaria">🏗️ Maquinaria</option>
                <option value="Herramienta">🛠️ Herramienta</option>
                <option value="Electrodoméstico">📺 Electrodoméstico</option>
                <option value="Otro">📦 Otro</option>

            </select>

        </div>

        <div>
            <label>Marca</label>

            <input
                type="text"
                name="brand"
                value="{{ old('brand') }}"
                placeholder="Ej. Toyota">
        </div>

        <div>
            <label>Modelo</label>

            <input
                type="text"
                name="model"
                value="{{ old('model') }}"
                placeholder="Ej. Hilux SRV">
        </div>

    </div>

</div>

<!-- ===================================== -->
<!-- IDENTIFICACIÓN -->
<!-- ===================================== -->

<div class="card-seccion">

    <h4>🏷️ Identificación</h4>

    <div class="grid-2">

        <div>
            <label>Código del Activo</label>

            <input
                type="text"
                name="asset_code"
                value="{{ old('asset_code') }}"
                placeholder="Ej. ACT-0001">
        </div>

        <div>
            <label>Número de Serie</label>

            <input
                type="text"
                name="serial_number"
                value="{{ old('serial_number') }}">
        </div>

        <div>
            <label>Estado</label>

            <select name="status">

                <option value="1"
                    {{ old('status',1)==1?'selected':'' }}>
                    Activo
                </option>

                <option value="0"
                    {{ old('status')==0?'selected':'' }}>
                    Inactivo
                </option>

            </select>

        </div>

    </div>

</div>

<!-- ===================================== -->
<!-- INFORMACIÓN FINANCIERA -->
<!-- ===================================== -->

<div class="card-seccion">

    <h4>💰 Información Financiera</h4>

    <div class="grid-2">

        <div>

            <label>Fecha de Compra</label>

            <input
                type="date"
                name="purchase_date"
                value="{{ old('purchase_date') }}">

        </div>

        <div>

            <label>Valor de Compra $</label>

            <input
        
                type="number"
                step="0.01"
                name="purchase_value"
                value="{{ old('purchase_value') }}">

        </div>

        <div>

            <label>Vida Útil (años)</label>

            <input
                type="number"
                name="useful_life"
                value="{{ old('useful_life') }}">

        </div>

    </div>

</div>

<!-- ===================================== -->
<!-- OBSERVACIONES -->
<!-- ===================================== -->

<div class="card-seccion">

    <h4>📝 Observaciones</h4>

    <div>

        <label>Descripción</label>

        <textarea
            name="description"
            rows="5"
            placeholder="Observaciones del activo...">{{ old('description') }}</textarea>

    </div>

</div>

<!-- ===================================== -->
<!-- BOTONES -->
<!-- ===================================== -->

<div style="margin-top:25px; display:flex; gap:10px;">

    <button
        type="submit"
        class="btn-primary-custom">

        💾 Guardar Activo

    </button>

    <a
        href="/inversiones/{{ $investment_id }}/assets"
        class="btn-secondary">

        Cancelar

    </a>

</div>


</form>
@endsection