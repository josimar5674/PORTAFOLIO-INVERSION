@extends('layouts.app')

@section('content')


<style>

.card-seccion {
    background: #ffffff;
    padding: 18px;
    border-radius: 12px;
    margin-bottom: 18px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    border: 1px solid #f1f5f9;
}

.card-seccion h4 {
    margin-bottom: 12px;
    font-weight: 600;
    color: #111827;
}

.grid-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 12px;
}

.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

input, select {
    padding: 10px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    transition: 0.2s;
    width: 100%;
}

input:focus, select:focus {
    border-color: #2563eb;
    outline: none;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
}

.total-box {
    background: linear-gradient(135deg, #111827, #1f2937);
    color: white;
    padding: 20px;
    border-radius: 12px;
    font-size: 20px;
    text-align: right;
    font-weight: 600;
}

</style>

<div style="
    width:100%;
    padding:25px;
    max-width:1100px;
    margin:auto;
    background:#f9fafb;
    border-radius:12px;
">


<div class="form-title" style="margin-bottom:20px;">
    ✏️ Editar Avalúo - {{ $avaluo->fecha_avaluo }}
</div>

<form method="POST" action="/inversiones/{{ $avaluo->inversion_id }}/avaluos/{{ $avaluo->id }}">
    @csrf
    @method('PUT')

    <input type="hidden" name="inversion_id" value="{{ $avaluo->inversion_id }}">
    <input type="hidden" name="unidad_terreno" id="unidad_terreno" value="{{ old('unidad_terreno', $avaluo->unidad_terreno ?? 'm2') }}">

    <!-- 🌱 TERRENO -->
    <div class="card-seccion">
        <h4>🌱 Terreno</h4>

        <div style="margin-bottom:10px;">
            <label>Unidad:</label>
            <select onchange="cambiarUnidad(this)" id="unidadTerreno" style="width:200px;">
                <option value="m2" {{ ($avaluo->unidad_terreno ?? 'm2') == 'm2' ? 'selected' : '' }}>M²</option>
                <option value="v2" {{ ($avaluo->unidad_terreno ?? 'm2') == 'v2' ? 'selected' : '' }}>V²</option>
            </select>
        </div>

        <div class="grid-3">
            <input type="number" step="0.01" id="area_terreno" name="area_terreno"
                value="{{ old('area_terreno', $avaluo->area_terreno) }}" oninput="calcularTerreno()">

            <input type="number" step="0.01" id="precio_terreno" name="precio_terreno"
                value="{{ old('precio_terreno', $avaluo->precio_terreno) }}" oninput="calcularTerreno()">

            <input type="number" step="0.01" id="subtotal_terreno" name="subtotal_terreno"
                value="{{ old('subtotal_terreno', $avaluo->subtotal_terreno) }}" readonly>
        </div>

        <small id="conversionInfo" style="color:#2563eb;"></small>
    </div>

    <!-- 🏗️ CONSTRUCCIÓN -->
    <div class="card-seccion">
        <h4>🏗️ Construcción</h4>

        <div class="grid-3">
            <input type="number" step="0.01" name="area_construccion"
                value="{{ old('area_construccion', $avaluo->area_construccion) }}" oninput="calcularConstruccion()">

            <input type="number" step="0.01" name="precio_construccion"
                value="{{ old('precio_construccion', $avaluo->precio_construccion) }}" oninput="calcularConstruccion()">

            <input type="number" step="0.01" name="subtotal_construccion"
                value="{{ old('subtotal_construccion', $avaluo->subtotal_construccion) }}" readonly>
        </div>
    </div>

    <!-- 📉 DEPRECIACIÓN -->
    <div class="card-seccion">
        <h4>📉 Depreciación</h4>

        <div class="grid-2">
            <input type="number" name="vida_util"
                value="{{ old('vida_util', $avaluo->vida_util) }}" oninput="calcularDepreciacion()">

            <input type="number" name="depreciacion"
                value="{{ old('depreciacion', $avaluo->depreciacion) }}" readonly>
        </div>
    </div>

    <!-- 📅 INFO -->
    <div class="card-seccion">
        <h4>📅 Información</h4>

        <div class="grid-2">
            <input type="date" name="fecha_avaluo"
                value="{{ old('fecha_avaluo', $avaluo->fecha_avaluo) }}">

            <input type="text" name="observaciones"
                value="{{ old('observaciones', $avaluo->observaciones) }}">
        </div>
    </div>

    <!-- 💰 TOTAL -->
    <div class="total-box">
        💰 Total del inmueble  
        <div style="font-size:28px; margin-top:5px;">
            L <span id="totalGeneral">{{ number_format($avaluo->valor_total, 2) }}</span>
        </div>
    </div>

    <input type="hidden" name="valor_total" id="valor_total"
        value="{{ old('valor_total', $avaluo->valor_total) }}">

    <!-- BOTONES -->
    <div style="margin-top:20px;">
        <button type="submit" class="btn-primary-custom">💾 Actualizar</button>
        <a href="/inversiones/{{ $avaluo->inversion_id }}/avaluos" class="btn-secondary">Cancelar</a>
    </div>

</form>

</div>

@endsection


<script>

let unidadActual = 'm2';

document.addEventListener("DOMContentLoaded", function () {

    const unidadInput = document.getElementById('unidad_terreno');
    if (unidadInput) {
        unidadActual = unidadInput.value || 'm2';
    }

    calcularTerreno();
    calcularConstruccion();
    calcularDepreciacion();

    document.getElementById('totalGeneral').style.transition = "0.3s";
});

function cambiarUnidad(select) {
    unidadActual = select.value;
    document.getElementById('unidad_terreno').value = unidadActual;
    calcularTerreno();
}

function calcularTerreno() {

    let area = parseFloat(document.getElementById('area_terreno').value) || 0;
    let precio = parseFloat(document.getElementById('precio_terreno').value) || 0;

    if (area === 0 && precio === 0) return;

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

function calcularConstruccion() {

    const area = parseFloat(document.querySelector('[name="area_construccion"]').value) || 0;
    const precio = parseFloat(document.querySelector('[name="precio_construccion"]').value) || 0;

    if (area === 0 && precio === 0) return;

    const subtotal = area * precio;

    document.querySelector('[name="subtotal_construccion"]').value = subtotal.toFixed(2);

    calcularTotal();
}

function calcularTotal() {

    const terreno = parseFloat(document.getElementById('subtotal_terreno').value) || 0;
    const construccion = parseFloat(document.querySelector('[name="subtotal_construccion"]').value) || 0;

    const total = terreno + construccion;

    const totalEl = document.getElementById('totalGeneral');

    totalEl.innerText = total.toFixed(2);
    document.getElementById('valor_total').value = total.toFixed(2);

    // animación suave
    totalEl.style.transform = "scale(1.05)";
    setTimeout(() => {
        totalEl.style.transform = "scale(1)";
    }, 150);

    calcularDepreciacion();
}

function calcularDepreciacion() {

    const totalConstruccion = parseFloat(document.querySelector('[name="subtotal_construccion"]').value) || 0;
    const vida = parseFloat(document.querySelector('[name="vida_util"]').value) || 0;

    const dep = vida > 0 ? totalConstruccion / vida : 0;

    document.querySelector('[name="depreciacion"]').value = dep.toFixed(2);
}

</script>