@extends('layouts.app')

@section('content')

<div class="form-card">

    <!-- 🔙 VOLVER -->
    <div style="margin-bottom:10px;">
        <a href="/inversiones/{{ $servicio->inversion_id }}/servicios" class="btn-secondary">
            ← Volver a Servicios
        </a>
    </div>

    <div class="form-title">
        ✏️ Editar Servicio - {{ $servicio->nombre }}
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

    <form method="POST" action="/inversiones/{{ $servicio->inversion_id }}/servicios/{{ $servicio->id }}">
        @csrf
        @method('PUT')

        <input type="hidden" name="inversion_id" value="{{ $servicio->inversion_id }}">

        <!-- NOMBRE -->
        <div class="form-group">
            <label class="form-label">Nombre del servicio</label>
            <input type="text" name="nombre" class="form-control"
                value="{{ old('nombre', $servicio->nombre) }}">
        </div>

        <!-- COSTO -->
        <div class="form-group">
            <label class="form-label">Costo mensual</label>
            <input type="number" step="0.01" name="costo_mensual" class="form-control"
                value="{{ old('costo_mensual', $servicio->costo_mensual) }}">
        </div>

        <!-- TIPO -->
        <div class="form-group">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control"
                value="{{ old('tipo', $servicio->tipo) }}">
        </div>

        <!-- DESCRIPCIÓN -->
        <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion', $servicio->descripcion) }}</textarea>
        </div>

        <!-- BOTONES -->
        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">💾 Actualizar</button>
            <a href="/inversiones/{{ $servicio->inversion_id }}/servicios" class="btn-secondary">Cancelar</a>
        </div>

    </form>

</div>

@endsection