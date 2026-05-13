@extends('layouts.app')

@section('content')

<div class="form-card" style="max-width:95%; width:95%;">

    <div style="margin-bottom:15px;">
        <a href="/inversiones/{{ $activo->inversion_id }}/activos-registrales"
           class="btn-secondary">
            ← Volver
        </a>
    </div>

    <div class="form-title">
        ✏️ Editar Activo Registral
    </div>

    <form method="POST"
          action="/activos-registrales/{{ $activo->id }}">

        @csrf
        @method('PUT')

        <div class="grid-2">

            <div class="form-group">
                <label>Ubicación del Inmueble</label>
                <input type="text"
                       name="ubicacion_inmueble"
                       class="form-control"
                       value="{{ $activo->ubicacion_inmueble }}">
            </div>

            <div class="form-group">
                <label>Ciudad</label>
                <input type="text"
                       name="ciudad"
                       class="form-control"
                       value="{{ $activo->ciudad }}">
            </div>

            <div class="form-group">
                <label>Número de Matrícula</label>
                <input type="text"
                       name="numero_matricula"
                       class="form-control"
                       value="{{ $activo->numero_matricula }}">
            </div>

            <div class="form-group">
                <label>Valor de Escrituración</label>
                <input type="number"
                       step="0.01"
                       name="valor_escrituracion"
                       class="form-control"
                       value="{{ $activo->valor_escrituracion }}">
            </div>

            <div class="form-group">
                <label>Clave Catastral IP</label>
                <input type="text"
                       name="clave_catastral_ip"
                       class="form-control"
                       value="{{ $activo->clave_catastral_ip }}">
            </div>

            <div class="form-group">
                <label>Clave Catastral Municipal</label>
                <input type="text"
                       name="clave_catastral_municipal"
                       class="form-control"
                       value="{{ $activo->clave_catastral_municipal }}">
            </div>

            <div class="form-group">
                <label>Zonificación</label>
                <input type="text"
                       name="zonificacion"
                       class="form-control"
                       value="{{ $activo->zonificacion }}">
            </div>

        </div>

        <hr style="margin:30px 0;">

<h3>📑 Inscripciones</h3>

<table style="width:100%; border-collapse: collapse;">

    <thead>

        <tr style="background:#f3f4f6;">

            <th>Fecha</th>
            <th>Acto</th>
            <th>Inscripción</th>
            <th>Descripción</th>
            <th>Digitalización</th>
            <th></th>

        </tr>

    </thead>

    <tbody id="tablaInscripciones">

        @foreach($activo->inscripciones as $inscripcion)

        <tr>

            <td>
                <input type="date"
                       name="fecha[]"
                       class="form-control"
                       value="{{ $inscripcion->fecha }}">
            </td>

            <td>
                <input type="text"
                       name="acto[]"
                       class="form-control"
                       value="{{ $inscripcion->acto }}">
            </td>

            <td>
                <input type="text"
                       name="inscripcion[]"
                       class="form-control"
                       value="{{ $inscripcion->inscripcion }}">
            </td>

            <td>
                <input type="text"
                       name="descripcion[]"
                       class="form-control"
                       value="{{ $inscripcion->descripcion }}">
            </td>

            <td>
                <input type="text"
                       name="digitalizacion_inscripcion[]"
                       class="form-control"
                       value="{{ $inscripcion->digitalizacion }}">
            </td>

            <td>

                <button type="button"
                        onclick="eliminarFila(this)">

                    🗑️

                </button>

            </td>

        </tr>

        @endforeach

        <!-- FILA VACÍA -->

        <tr>

            <td>
                <input type="date"
                       name="fecha[]"
                       class="form-control">
            </td>

            <td>
                <input type="text"
                       name="acto[]"
                       class="form-control">
            </td>

            <td>
                <input type="text"
                       name="inscripcion[]"
                       class="form-control">
            </td>

            <td>
                <input type="text"
                       name="descripcion[]"
                       class="form-control">
            </td>

            <td>
                <input type="text"
                       name="digitalizacion_inscripcion[]"
                       class="form-control">
            </td>

            <td>

                <button type="button"
                        onclick="eliminarFila(this)">

                    🗑️

                </button>

            </td>

        </tr>

    </tbody>

</table>

<div style="margin-top:15px;">

    <button type="button"
            onclick="agregarFila()"
            class="btn-secondary">

        ➕ Agregar inscripción

    </button>

</div>

        <div style="margin-top:30px;">
            <button type="submit"
                    class="btn-primary-custom">
                💾 Actualizar
            </button>
        </div>

    </form>

</div>

<script>

function agregarFila() {

    let tabla = document.getElementById('tablaInscripciones');

    let fila = tabla.rows[0].cloneNode(true);

    fila.querySelectorAll('input').forEach(input => {
        input.value = '';
    });

    tabla.appendChild(fila);
}

function eliminarFila(btn) {

    let filas = document.querySelectorAll('#tablaInscripciones tr');

    if (filas.length > 1) {
        btn.closest('tr').remove();
    }
}

</script>

@endsection