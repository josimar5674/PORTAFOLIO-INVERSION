@extends('layouts.app')

@section('content')


<link rel="stylesheet" href="{{ asset('css/entidades.css') }}">

<div style="max-width:1200px; margin:auto; padding:20px;">

<!-- 🔙 -->
<div style="margin-bottom:15px;">
    <a href="/entidades" class="btn-secondary">
        ← Volver a Entidades 
    </a>
</div>

<div class="form-title" style="margin-bottom:20px;">
    🏢 Nueva Entidad
</div>



<form method="POST" action="/entidades">
    @csrf

    <!-- 🔹 INFORMACIÓN LEGAL -->
<div class="form-card" style="width:100%; max-width:100%;">

        <h4>📄 Información Legal</h4>

        <div class="grid-2">

            <div>
                <label>Identificador Tributario</label>
                <input type="text"
                       name="identificador_tributario"
                       class="form-control">
            </div>

            <div>
                <label>Tipo Societario</label>

                <select name="tipo_societario"
                        class="form-control">

                    <option value="">Seleccione</option>
                    <option>S.A.</option>
                    <option>S. de R.L.</option>
                    <option>Fundación</option>
                    <option>Cooperativa</option>

                </select>
            </div>

            <div>
                <label>Matrícula</label>
                <input type="text"
                       name="matricula"
                       class="form-control">
            </div>

            <div>
                <label>Registro</label>
                <input type="text"
                       name="registro"
                       class="form-control">
            </div>

            <div>
                <label>Notario</label>
                <input type="text"
                       name="notario"
                       class="form-control">
            </div>

            <div>
                <label>Instrumento</label>
                <input type="text"
                       name="instrumento"
                       class="form-control">
            </div>

            <div style="grid-column: span 2;">
                <label>Denominación / Razón Social</label>

                <input type="text"
                       name="denominacion_social"
                       class="form-control">
            </div>

        </div>

    

    <!-- 🔹 CAPITAL -->
  



        <h4>💰 Capital e Inscripción</h4>

        <div class="grid-2">

            <div>
                <label>Capital Social Mínimo</label>

                <input type="number"
                       step="0.01"
                       name="capital_social_min"
                       class="form-control">
            </div>

            <div>
                <label>Capital Social Máximo</label>

                <input type="number"
                       step="0.01"
                       name="capital_social_max"
                       class="form-control">
            </div>

            <div>
                <label>Fecha Constitución</label>

                <input type="date"
                       name="fecha_constitucion"
                       class="form-control">
            </div>

            <div>
                <label>Fecha Inscripción</label>

                <input type="date"
                       name="fecha_inscripcion"
                       class="form-control">
            </div>

            <div>
                <label>Inscripción</label>

                <input type="text"
                       name="inscripcion"
                       class="form-control">
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



    <!-- 🔹 CONFIG -->

  



    <!-- 🔹 BOTONES -->
    <div style="
        display:flex;
        justify-content:space-between;
        margin-top:20px;
    ">

        <a href="/entidades"
           class="btn-secondary">

            ← Cancelar
        </a>

        <button type="submit"
                class="btn-primary-custom">

            💾 Guardar Entidad
        </button>

    </div>

</form>

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

window.sociosActuales = [];

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

select.required = true;
input.required = true;
</script>



@endsection

