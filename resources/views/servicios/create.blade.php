@extends('layouts.app')

@section('content')

<div class="form-card">

    <!-- 🔙 VOLVER -->
    <div style="margin-bottom:10px;">
        <a href="/inversiones/{{ $inversion_id }}/servicios" class="btn-secondary">
            ← Volver a Servicios
        </a>
    </div>

    <div class="form-title">
        ➕ Nuevo Servicio (Inversión #{{ $inversion_id }})
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

    <form method="POST" action="/inversiones/{{ $inversion_id }}/servicios">
        @csrf

        <input type="hidden" name="inversion_id" value="{{ $inversion_id }}">

        <!-- NOMBRE -->
        <div class="form-group">
            <label class="form-label">Nombre del servicio</label>
            <input type="text" name="nombre" class="form-control"
                value="{{ old('nombre') }}" placeholder="Ej: ENEE">
        </div>

        <!-- COSTO -->
        <div class="form-group">
            <label class="form-label">Costo mensual</label>
            <input type="number" step="0.01" name="costo_mensual" class="form-control"
                value="{{ old('costo_mensual') }}">
        </div>

        <!-- TIPO -->
        <div class="form-group">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control"
                value="{{ old('tipo') }}" placeholder="Energía, Agua, Internet">
        </div>

        <!-- DESCRIPCIÓN -->
        <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
        </div>

        <!-- BOTONES -->
        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">💾 Guardar</button>
            <a href="/inversiones/{{ $inversion_id }}/servicios" class="btn-secondary">Cancelar</a>
        </div>

    </form>

</div>

@endsection