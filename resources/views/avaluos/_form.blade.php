<form
    method="POST"
    action="{{ isset($avaluo)
        ? '/inversiones/'.$avaluo->inversion_id.'/avaluos/'.$avaluo->id
        : '/inversiones/'.$inversion_id.'/avaluos' }}">

    @csrf

    @if(isset($avaluo))
        @method('PUT')
    @endif
   <input
    type="hidden"
    name="inversion_id"
    value="{{ $avaluo->inversion_id ?? $inversion_id }}">
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
        value="{{ old('area_terreno', $avaluo->area_terreno ?? '') }}"
        oninput="calcularTerreno()">
</div>

<div>
    <label>Precio por m²</label>
    <input
        type="number"
        step="0.01"
        id="precio_terreno"
        name="precio_terreno"
        value="{{ old('precio_terreno', $avaluo->precio_terreno ?? '') }}"
        oninput="calcularTerreno()">
</div>

<div>
    <label>Subtotal Terreno</label>
    <input
        type="number"
        step="0.01"
        id="subtotal_terreno"
        name="subtotal_terreno"
        value="{{ old('subtotal_terreno', $avaluo->subtotal_terren ?? '') }}"
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
                value="{{ old('area_construccion', $avaluo->area_construccion ?? '') }}"
                oninput="calcularConstruccion()">
        </div>

        <div>
            <label>Precio por m²</label>

            <input
                type="number"
                step="0.01"
                name="precio_construccion"
                value="{{ old('precio_construccion', $avaluo->precio_construccion ?? '') }}"
                oninput="calcularConstruccion()">
        </div>

        <div>
            <label>Subtotal Construcción</label>

            <input
                type="number"
                step="0.01"
                name="subtotal_construccion"
                value="{{ old('subtotal_construccion', $avaluo->subtotal_construccion ?? '') }}"
                readonly>
        </div>

    </div>

</div>


    <!-- 💰 TOTAL -->
  

   <div class="total-box">
    💰 Total del inmueble: $
    <span id="totalGeneral">
        {{ number_format($avaluo->valor_total ?? 0, 2) }}
    </span>
</div>

    <input type="hidden" name="valor_total" id="valor_total"
        value="{{ old('valor_total', $avaluo->valor_total ?? '') }}">


    <!-- 📉 DEPRECIACIÓN -->
<div class="card-seccion">

    <h4>📉 Depreciación</h4>

    <div class="grid-2">

        <div>
            <label>Vida Útil (años)</label>

            <input
                type="number"
                name="vida_util"
                value="{{ old('vida_util', $avaluo->vida_util ?? '') }}"
                oninput="calcularDepreciacion()">
        </div>

        <div>
            <label>Depreciación Anual</label>

            <input
                type="number"
                name="depreciacion"
                value="{{ old('depreciacion', $avaluo->depreciacion ?? '') }}"
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
            value="{{ old('fecha_avaluo', $avaluo->fecha_avaluo ?? '') }}">
    </div>

    <div style="margin-top:15px;">
        <label>Observaciones</label>

        <textarea
            name="observaciones"
            rows="5"
            class="form-control">{{ old('observaciones', $avaluo->observaciones ?? '') }}</textarea>
    </div>



</div>

<input
    type="hidden"
    name="return_url"
    value="{{ $returnUrl ?? '' }}">

    <!-- BOTONES -->
   <div style="margin-top:20px; display:flex; gap:10px;">

    <button
        type="submit"
        class="btn-primary-custom">

        @if(isset($avaluo))
            💾 Actualizar
        @else
            💾 Guardar
        @endif

    </button>

    <button
        type="button"
        class="btn-secondary"
        onclick="cerrarModal('modalAvaluo')">

        Cancelar

    </button>

</div>



</form>

@if(isset($avaluo))

<hr style="margin:30px 0;">

@include('components.documents',[

    'modelo' => $avaluo,

    'modelClass' => 'App\Models\Avaluo',

    'returnUrl' => $returnUrl

])

<hr style="margin:30px 0;">

@include('components.notes',[

    'modelo' => $avaluo,

    'modelClass' => 'App\Models\Avaluo',

    'returnUrl' => $returnUrl

])

@endif

 