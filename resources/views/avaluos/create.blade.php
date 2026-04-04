@extends('layouts.app')

@section('content')

<div class="form-card">

    <!-- 🔙 VOLVER -->
    <div style="margin-bottom:10px;">
        <a href="/inversiones/{{ $inversion_id }}/avaluos" class="btn-secondary">
            ← Volver a Avalúos
        </a>
    </div>

    <div class="form-title">
        ➕ Nuevo Avalúo (Inversión #{{ $inversion_id }})
    </div>

    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/inversiones/{{ $inversion_id }}/avaluos">
        @csrf

        <input type="hidden" name="inversion_id" value="{{ $inversion_id }}">

        <!-- VALOR TERRENO -->
        <div class="form-group">
            <label class="form-label">Valor del terreno</label>
            <input type="number" step="0.01" name="valor_terreno" class="form-control"
                value="{{ old('valor_terreno') }}">
        </div>

        <!-- VALOR CONSTRUCCIÓN -->
        <div class="form-group">
            <label class="form-label">Valor de construcción</label>
            <input type="number" step="0.01" name="valor_construccion" class="form-control"
                value="{{ old('valor_construccion') }}">
        </div>

        <!-- FECHA -->
        <div class="form-group">
            <label class="form-label">Fecha de avalúo</label>
            <input type="date" name="fecha_avaluo" class="form-control"
                value="{{ old('fecha_avaluo') }}">
        </div>

        <!-- OBSERVACIONES -->
        <div class="form-group">
            <label class="form-label">Observaciones</label>
            <textarea name="observaciones" class="form-control">{{ old('observaciones') }}</textarea>
        </div>

        <!-- BOTONES -->
        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">💾 Guardar</button>
            <a href="/inversiones/{{ $inversion_id }}/avaluos" class="btn-secondary">Cancelar</a>
        </div>

    </form>

</div>

@endsection