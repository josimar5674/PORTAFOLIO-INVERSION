@extends('layouts.app')

@section('content')

<div class="form-card">

    <div class="form-title">➕ Crear Inversión</div>

    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/inversiones">
        @csrf

        <!-- NOMBRE -->
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control"
                value="{{ old('nombre') }}" placeholder="Ej: Torre Norte">
        </div>

        <!-- UBICACIÓN -->
        <div class="form-group">
            <label class="form-label">Ubicación</label>
            <input type="text" name="ubicacion" class="form-control"
                value="{{ old('ubicacion') }}" placeholder="Ciudad, zona, etc.">
        </div>

        <!-- DESCRIPCIÓN -->
        <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control"
                placeholder="Detalles de la inversión...">{{ old('descripcion') }}</textarea>
        </div>

        <!-- CLIENTE -->
        <div class="form-group">
            <label class="form-label">Cliente</label>
            <select name="cliente_id" class="form-control">
                <option value="">-- Seleccionar cliente --</option>

                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}"
                        {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- BOTONES -->
        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">💾 Guardar</button>
            <a href="/inversiones" class="btn-secondary">← Cancelar</a>
        </div>

    </form>

</div>

@endsection