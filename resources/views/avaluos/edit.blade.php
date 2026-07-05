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

.grid-3 {
    display:grid;
    grid-template-columns:1fr 1fr 1fr;
    gap:12px;
}

.grid-2 {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
}

input,
select,
textarea{

    padding:10px;

    border:1px solid var(--border);

    border-radius:8px;

    transition:.2s;

    width:100%;

    background:var(--surface);

    color:var(--text);

}

input:focus,
select:focus,
textarea:focus{

    border-color:var(--primary);

    outline:none;

    box-shadow:0 0 0 2px rgba(234,207,51,.20);

}

label{

    color:var(--text);

}

.total-box{

    background:linear-gradient(135deg,#111827,#1f2937);

    color:white;

    padding:20px;

    border-radius:12px;

    font-size:20px;

    text-align:right;

    font-weight:600;

}

</style>

<div style="
    width:100%;
    padding:25px;
    max-width:1100px;
    margin:auto;
    background:var(--surface-2);
    border-radius:12px;
">

<div class="form-title" style="margin-bottom:20px;">
     Avalúo - {{ $avaluo->fecha_avaluo }} - {{ $avaluo->inversion->nombre }}
</div>

<a href="/inversiones/{{ $inversion_id ?? $avaluo->inversion_id }}/avaluos"

   class="btn-secondary"

   style="display:inline-block; margin-bottom:20px;">

    ← Volver

</a>
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
         <div>
    <label>Área Terreno</label>
    <input
        type="number"
        step="0.01"
        id="area_terreno"
        name="area_terreno"
        value="{{ old('area_terreno', $avaluo->area_terreno) }}"
        oninput="calcularTerreno()">
</div>

<div>
    <label>Precio por m²</label>
    <input
        type="number"
        step="0.01"
        id="precio_terreno"
        name="precio_terreno"
        value="{{ old('precio_terreno', $avaluo->precio_terreno) }}"
        oninput="calcularTerreno()">
</div>

<div>
    <label>Subtotal Terreno</label>
    <input
        type="number"
        step="0.01"
        id="subtotal_terreno"
        name="subtotal_terreno"
        value="{{ old('subtotal_terreno', $avaluo->subtotal_terreno) }}"
        readonly>
</div>
        </div>

<small id="conversionInfo"
       style="
           display:block;
           color:var(--primary);
           margin-top:12px;
       ">
</small>   </div>

    <!-- 🏗️ CONSTRUCCIÓN -->
<div class="card-seccion">

    <h4>🏗️ Edificios</h4>

    <div class="grid-3">

        <div>
            <label>Área Construcción</label>

            <input
                type="number"
                step="0.01"
                name="area_construccion"
                value="{{ old('area_construccion', $avaluo->area_construccion) }}"
                oninput="calcularConstruccion()">
        </div>

        <div>
            <label>Precio por m²</label>

            <input
                type="number"
                step="0.01"
                name="precio_construccion"
                value="{{ old('precio_construccion', $avaluo->precio_construccion) }}"
                oninput="calcularConstruccion()">
        </div>

        <div>
            <label>Subtotal Construcción</label>

            <input
                type="number"
                step="0.01"
                name="subtotal_construccion"
                value="{{ old('subtotal_construccion', $avaluo->subtotal_construccion) }}"
                readonly>
        </div>

    </div>

</div>


    <!-- 💰 TOTAL -->
  

      <div class="total-box">
            💰 Total del inmueble: $
           <span id="totalGeneral">{{ number_format($avaluo->valor_total, 2) }}</span>
        </div>

    <input type="hidden" name="valor_total" id="valor_total"
        value="{{ old('valor_total', $avaluo->valor_total) }}">


    <!-- 📉 DEPRECIACIÓN -->
<div class="card-seccion">

    <h4>📉 Depreciación</h4>

    <div class="grid-2">

        <div>
            <label>Vida Útil (años)</label>

            <input
                type="number"
                name="vida_util"
                value="{{ old('vida_util', $avaluo->vida_util) }}"
                oninput="calcularDepreciacion()">
        </div>

        <div>
            <label>Depreciación Anual</label>

            <input
                type="number"
                name="depreciacion"
                value="{{ old('depreciacion', $avaluo->depreciacion) }}"
                readonly>
        </div>

    </div>

</div>

<div class="card-seccion">

    <h4>📅 Información</h4>

    <div>
        <label>Fecha del Avalúo</label>

        <input
            type="date"
            name="fecha_avaluo"
            value="{{ old('fecha_avaluo', $avaluo->fecha_avaluo) }}">
    </div>

    <div style="margin-top:15px;">
        <label>Observaciones</label>

        <textarea
            name="observaciones"
            rows="5"
            class="form-control">{{ old('observaciones', $avaluo->observaciones) }}</textarea>
    </div>

</div>

    <!-- BOTONES -->
    <div style="margin-top:20px;">
        <button type="submit" class="btn-primary-custom">💾 Actualizar</button>
        <a href="/inversiones/{{ $avaluo->inversion_id }}/avaluos" class="btn-secondary">Cancelar</a>
    </div>

</form>
<hr style="margin:30px 0;">

<div class="card-seccion">

    <h4>📄 Documentos del Avalúo</h4>

    <form
        method="POST"
        action="/documentos"
        enctype="multipart/form-data">

        @csrf

        <input
            type="hidden"
            name="documentable_type"
            value="App\Models\Avaluo">

        <input
            type="hidden"
            name="documentable_id"
            value="{{ $avaluo->id }}">

        <div class="grid-2">

            <div>
                <label>Nombre del Documento</label>

                <input
                    type="text"
                    name="nombre"
                    class="form-control"
                    placeholder="Ej: Escritura, Croquis, Fotos, etc.">
            </div>

            <div>
                <label>Archivo</label>

                <input
                    type="file"
                    name="archivo"
                    class="form-control">
            </div>

        </div>

        <div style="margin-top:15px;">

            <button
                type="submit"
                class="btn-primary-custom">

                📤 Subir Documento

            </button>

        </div>

    </form>

</div>

<div class="card-seccion">

    <h4>📁 Archivos Cargados</h4>

    @forelse($avaluo->documentos as $documento)

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:10px;
            border:1px solid #e5e7eb;
            border-radius:8px;
            margin-bottom:10px;
        ">

            <div>

                📄 {{ $documento->nombre }}

            </div>

            <div style="
                display:flex;
                gap:10px;
            ">

                <a
                    href="{{ asset('storage/'.$documento->archivo) }}"
                    target="_blank"
                    class="btn-secondary">

                    Ver

                </a>

                <form
                    method="POST"
                    action="/documentos/{{ $documento->id }}">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn-danger">

                        🗑️

                    </button>

                </form>

            </div>

        </div>

    @empty

<p style="color:var(--text-secondary);">
                No hay documentos cargados.
        </p>

    @endforelse

</div>

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