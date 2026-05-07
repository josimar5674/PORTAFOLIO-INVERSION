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
    <div class="card-seccion">

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

    </div>

    <!-- 🔹 CAPITAL -->
    <div class="card-seccion">

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

    </div>

    <!-- 🔹 REPRESENTANTES -->
    <div class="card-seccion">

        <h4>👔 Representantes</h4>

        <div class="grid-2">

            <div>
                <label>Gerente General</label>

                <input type="text"
                       name="gerente_general"
                       class="form-control">
            </div>

            <div>
                <label>Sub Gerente General</label>

                <input type="text"
                       name="subgerente_general"
                       class="form-control">
            </div>

            <div>
                <label>Comisario</label>

                <input type="text"
                       name="comisario"
                       class="form-control">
            </div>

            <div>
                <label>Digitalización (PDF)</label>

                <input type="text"
                       name="digitalizacion"
                       class="form-control">
            </div>

        </div>

    </div>

    <!-- 🔹 CONFIG -->
    <div class="card-seccion">

        <h4>⚙️ Configuración</h4>

        <div class="checkbox-group">

            <label>
                <input type="checkbox"
                       name="es_entidad"
                       value="1">

                Es Entidad
            </label>

            <label>
                <input type="checkbox"
                       name="es_apnfd"
                       value="1">

                Es APNFD
            </label>

        </div>

    </div>

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

@endsection