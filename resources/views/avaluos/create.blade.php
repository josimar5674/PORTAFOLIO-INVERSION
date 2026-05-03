<style>

.card-seccion {
    background: #ffffff;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.card-seccion h4 {
    margin-bottom: 10px;
}

.grid-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 10px;
}

.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

input {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 6px;
}

.total-box {
    background: #111827;
    color: white;
    padding: 15px;
    border-radius: 10px;
    font-size: 18px;
    text-align: right;
}

</style>

@extends('layouts.app')

@section('content')
<div style="width:100%; padding:20px; max-width:1200px; margin:auto;">

    <div class="form-title" style="margin-bottom:20px;">
        🏠 Avalúo - Inversión #{{ $inversion_id }}
    </div>

    <form method="POST" action="/inversiones/{{ $inversion_id }}/avaluos">
        @csrf

        <input type="hidden" name="inversion_id" value="{{ $inversion_id }}">

        <!-- 🔹 TERRENO -->
    <div class="card-seccion">
    <h4>🌱 Terreno</h4>

    <!-- Selector -->
    <div style="margin-bottom:10px;">
        <label>Unidad:</label>
        <select id="unidadTerreno" onchange="cambiarUnidad(this)">
            <option value="m2">Metros cuadrados (M²)</option>
            <option value="v2">Varas cuadradas (V²)</option>
        </select>
    </div>

    <div class="grid-3">
     <input type="number" id="area_terreno" name="area_terreno" oninput="calcularTerreno()">

<input type="number" id="precio_terreno" name="precio_terreno" oninput="calcularTerreno()">

<input type="number" id="subtotal_terreno" name="subtotal_terreno" readonly>
    </div>

<small id="conversionInfo" style="
    color:#2563eb;
    font-weight:500;
    display:block;
    margin-top:5px;
"></small></div>

<input type="hidden" name="unidad_terreno" id="unidad_terreno" value="m2">

        <!-- 🔹 CONSTRUCCIÓN -->
        <div class="card-seccion">
            <h4>🏗️ Construcción</h4>

            <div class="grid-3">
                <input type="number" step="0.01" name="area_construccion" placeholder="Área" oninput="calcularConstruccion()">
                <input type="number" step="0.01" name="precio_construccion" placeholder="Precio x M²" oninput="calcularConstruccion()">
                <input type="number" step="0.01" name="subtotal_construccion" placeholder="Subtotal" readonly>
            </div>
        </div>



        <!-- 🔹 DEPRECIACIÓN -->
        <div class="card-seccion">
            <h4>📉 Depreciación</h4>

            <div class="grid-2">
                <input type="number" name="vida_util" placeholder="Vida útil (años)" oninput="calcularDepreciacion()">
                <input type="number" name="depreciacion" placeholder="Depreciación anual" readonly>
            </div>
        </div>

        <div class="card-seccion">
    <h4>📅 Información del Avalúo</h4>

    <div class="grid-2">
        <input type="date" name="fecha_avaluo" value="{{ old('fecha_avaluo') }}">
        <input type="text" name="observaciones" placeholder="Observaciones"
               value="{{ old('observaciones') }}">
    </div>
</div>
        <!-- 🔹 TOTAL -->
        <div class="total-box">
            💰 Total del inmueble: 
            <span id="totalGeneral">0.00</span>
        </div>

        <input type="hidden" name="valor_total" id="valor_total">

        <!-- BOTONES -->
     <div style="margin-top:20px; display:flex; gap:10px; align-items:center;">

    <button type="submit" class="btn-primary-custom">
        💾 Guardar
    </button>

    <a href="/inversiones/{{ $inversion_id ?? $avaluo->inversion_id }}/avaluos" class="btn-secondary">
        ← Volver a Avalúos
    </a>

</div>
    </form>

</div>

<script>

let unidadActual = 'm2';

// 🔄 CAMBIAR UNIDAD
function cambiarUnidad(select) {
    unidadActual = select.value;

    document.getElementById('unidad_terreno').value = unidadActual;

    // limpiar campos
    document.getElementById('area_terreno').value = '';
    document.getElementById('precio_terreno').value = '';
    document.getElementById('subtotal_terreno').value = '';

    document.getElementById('conversionInfo').innerText = '';

    calcularTotal();
}

// 🌱 TERRENO (CONVERSIÓN AUTOMÁTICA)
function calcularTerreno() {
    let area = parseFloat(document.getElementById('area_terreno').value) || 0;
    let precio = parseFloat(document.getElementById('precio_terreno').value) || 0;

    let areaEnM2 = area;

    if (unidadActual === 'v2') {
        areaEnM2 = area * 0.6987;

        document.getElementById('conversionInfo').innerText =
            `${area} v² ≈ ${areaEnM2.toFixed(2)} m²`;

    } else {
        const areaEnV2 = area * 1.43;

        document.getElementById('conversionInfo').innerText =
            `${area} m² ≈ ${areaEnV2.toFixed(2)} v²`;
    }

    const subtotal = areaEnM2 * precio;

    document.getElementById('subtotal_terreno').value = subtotal.toFixed(2);

    calcularTotal();
}


// 🏗️ CONSTRUCCIÓN
function calcularConstruccion() {
    const area = parseFloat(document.querySelector('[name="area_construccion"]').value) || 0;
    const precio = parseFloat(document.querySelector('[name="precio_construccion"]').value) || 0;

    const subtotal = area * precio;

    document.querySelector('[name="subtotal_construccion"]').value = subtotal.toFixed(2);

    calcularTotal();
}

// 💰 TOTAL GENERAL
function calcularTotal() {

    const terreno = parseFloat(document.getElementById('subtotal_terreno').value) || 0;
    const construccion = parseFloat(document.querySelector('[name="subtotal_construccion"]').value) || 0;

    const total = terreno + construccion;

    document.getElementById('totalGeneral').innerText = total.toFixed(2);
    document.getElementById('valor_total').value = total.toFixed(2);

    calcularDepreciacion();
}

// 📉 DEPRECIACIÓN
function calcularDepreciacion() {
    const totalConstruccion = parseFloat(document.querySelector('[name="subtotal_construccion"]').value) || 0;
    const vida = parseFloat(document.querySelector('[name="vida_util"]').value) || 0;

    const dep = vida > 0 ? totalConstruccion / vida : 0;

    document.querySelector('[name="depreciacion"]').value = dep.toFixed(2);
}

</script>

@endsection