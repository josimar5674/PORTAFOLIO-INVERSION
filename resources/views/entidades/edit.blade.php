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
   

        <h4>👔 Representantes</h4>

        <div class="grid-2">

            <div>
                <label>Gerente General</label>
                <input type="text"
                       name="gerente_general"
                       class="form-control"
                       value="{{ old('gerente_general', $entidad->gerente_general) }}">
            </div>

            <div>
                <label>Subgerente</label>
                <input type="text"
                       name="subgerente_general"
                       class="form-control"
                       value="{{ old('subgerente_general', $entidad->subgerente_general) }}">
            </div>

            <div>
                <label>Comisario</label>
                <input type="text"
                       name="comisario"
                       class="form-control"
                       value="{{ old('comisario', $entidad->comisario) }}">
            </div>

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




</div>





@endsection