@extends('layouts.app')

@section('content')

<div style="max-width:1200px; margin:auto; padding:20px;">

<!-- 🔙 -->
<div style="margin-bottom:15px;">
@if(request('inversion_id'))

<a href="/inversiones/{{ request('inversion_id') }}/entidades"
   class="btn-secondary">

    ← Volver

</a>

@else

<a href="/entidades"
   class="btn-secondary">

    ← Volver

</a>

@endif
</div>

<div class="form-title" style="margin-bottom:20px;">
    ✏️ Editar Entidad
</div>

<form method="POST"
      action="/entidades/{{ $entidad->id }}">
    @csrf
    @method('PUT')

    <!-- 🔹 INFORMACIÓN LEGAL -->
<div class="form-card" style="width:100%; max-width:100%;">

        <h4>📄 Información Legal</h4>

        <div class="grid-2">

            <div>
                <label>Identificador Tributario</label>
                <input type="text"
                       name="identificador_tributario"
                       class="form-control"
                       value="{{ old('identificador_tributario', $entidad->identificador_tributario) }}">
            </div>

            <div>
                <label>Tipo Societario</label>
                <input type="text"
                       name="tipo_societario"
                       class="form-control"
                       value="{{ old('tipo_societario', $entidad->tipo_societario) }}">
            </div>

            <div>
                <label>Matrícula</label>
                <input type="text"
                       name="matricula"
                       class="form-control"
                       value="{{ old('matricula', $entidad->matricula) }}">
            </div>

            <div>
                <label>Registro</label>
                <input type="text"
                       name="registro"
                       class="form-control"
                       value="{{ old('registro', $entidad->registro) }}">
            </div>

            <div>
                <label>Notario</label>
                <input type="text"
                       name="notario"
                       class="form-control"
                       value="{{ old('notario', $entidad->notario) }}">
            </div>

            <div>
                <label>Instrumento</label>
                <input type="text"
                       name="instrumento"
                       class="form-control"
                       value="{{ old('instrumento', $entidad->instrumento) }}">
            </div>

            <div style="grid-column:span 2;">
                <label>Denominación Social</label>
                <input type="text"
                       name="denominacion_social"
                       class="form-control"
                       value="{{ old('denominacion_social', $entidad->denominacion_social) }}">
            </div>

        </div>

    

    <!-- 🔹 CAPITAL -->
    

        <h4>💰 Capital</h4>

        <div class="grid-2">

            <div>
                <label>Capital Mínimo</label>
                <input type="number"
                       step="0.01"
                       name="capital_social_min"
                       class="form-control"
                       value="{{ old('capital_social_min', $entidad->capital_social_min) }}">
            </div>

            <div>
                <label>Capital Máximo</label>
                <input type="number"
                       step="0.01"
                       name="capital_social_max"
                       class="form-control"
                       value="{{ old('capital_social_max', $entidad->capital_social_max) }}">
            </div>

            <div>
                <label>Fecha Constitución</label>
                <input type="date"
                       name="fecha_constitucion"
                       class="form-control"
                       value="{{ old('fecha_constitucion', $entidad->fecha_constitucion) }}">
            </div>

            <div>
                <label>Fecha Inscripción</label>
                <input type="date"
                       name="fecha_inscripcion"
                       class="form-control"
                       value="{{ old('fecha_inscripcion', $entidad->fecha_inscripcion) }}">
            </div>

        </div>

    

    <!-- 🔹 REPRESENTANTES -->
   
<h4>👥 Socios</h4>

<div id="socios-container">

</div>

<div style="margin-top:15px;">

    <button
        type="button"
        id="agregarSocio"
        class="btn-secondary">

        + Agregar Socio

    </button>

</div>

<div style="
    margin-top:20px;
    padding:12px;
    border-radius:8px;
    font-weight:bold;
">

    Total de participación:

    <span id="totalPorcentaje"
          style="color:#ca8a04;">
        0%
    </span>

</div>



    <!-- BOTONES -->
<!-- BOTONES -->
<div style="
    display:flex;
    justify-content:space-between;
    margin-top:20px;
">

    @if(request('inversion_id'))

        <a href="/inversiones/{{ request('inversion_id') }}/entidades"
           class="btn-secondary">

            ← Cancelar

        </a>

    @else

        <a href="/entidades"
           class="btn-secondary">

            ← Cancelar

        </a>

    @endif

    <button type="submit"
            class="btn-primary-custom">

        💾 Actualizar

    </button>

</div>

<hr>
</form>



@include('components.notes',[
    'modelo' => $entidad,
    'modelClass' => 'App\Models\Entidad'
])  

<hr>

@include('components.documents',[
    'modelo' => $entidad,
    'modelClass' => 'App\Models\Entidad'
])


@include('components.alerts',[
    'modelo' => $entidad,
    'referencia' => 'matricula',
    'modelClass' => 'App\Models\Entidad'
])



</div>


<template id="filaSocio">

    <div class="fila-socio"
         style="
            display:grid;
            grid-template-columns:2fr 120px 50px;
            gap:12px;
            margin-bottom:12px;
         ">

        <select
            name=""
            class="form-control">

            <option value="">Seleccione un socio</option>

            @foreach($clientes as $cliente)

                <option value="{{ $cliente->id }}">
                    {{ $cliente->nombre }}
                </option>

            @endforeach

        </select>

        <input
            type="number"
            class="form-control porcentaje"
            name=""
            min="0"
            max="100"
            step="0.01"
            value="0">

        <button
            type="button"
            class="btnEliminar btn-secondary">

            🗑

        </button>

    </div>

</template>


<script>

window.sociosActuales = @json($sociosActuales);

document.addEventListener('DOMContentLoaded', () => {

    const container = document.getElementById('socios-container');

    if (!container) {
        return;
    }

    const template = document.getElementById('filaSocio');
    const btnAgregar = document.getElementById('agregarSocio');
    const totalTexto = document.getElementById('totalPorcentaje');

    let indiceSocio = 0;

    function recalcular() {

        let total = 0;

        document.querySelectorAll('.porcentaje').forEach(input => {

            total += parseFloat(input.value) || 0;

        });

        totalTexto.textContent = total.toFixed(2) + "%";

        if (Math.abs(total - 100) < 0.01) {

            totalTexto.style.color = "#16a34a";

        } else if (total > 100) {

            totalTexto.style.color = "#dc2626";

        } else {

            totalTexto.style.color = "#ca8a04";

        }

    }

    function agregarSocio(clienteId = "", porcentaje = "") {

        const clone = template.content.cloneNode(true);

        const fila = clone.querySelector('.fila-socio');

        const select = fila.querySelector('select');

        const input = fila.querySelector('.porcentaje');

        select.name = `socios[${indiceSocio}][cliente_id]`;
        input.name = `socios[${indiceSocio}][porcentaje]`;
        select.required = true;
input.required = true;

        if (clienteId !== "") {
            select.value = clienteId;
        }

        if (porcentaje !== "") {
            input.value = porcentaje;
        }

        indiceSocio++;

        container.appendChild(clone);

        recalcular();

    }

    btnAgregar.addEventListener('click', () => {

        agregarSocio();

    });

    container.addEventListener('input', function (e) {

        if (e.target.classList.contains('porcentaje')) {

            recalcular();

        }

    });

    container.addEventListener('click', function (e) {

        if (e.target.classList.contains('btnEliminar')) {

            e.target.closest('.fila-socio').remove();

            recalcular();

        }

    });

    if (
        window.sociosActuales &&
        window.sociosActuales.length > 0
    ) {

        window.sociosActuales.forEach(socio => {

            agregarSocio(
                socio.cliente_id,
                socio.porcentaje
            );

        });

    } else {

        agregarSocio();

    }

});


</script>


@endsection