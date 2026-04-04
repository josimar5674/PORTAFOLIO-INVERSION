@extends('layouts.app')

@section('content')

<div class="form-card">

    <div class="form-title">✏️ Editar Inversión</div>

    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/inversiones/{{ $inversion->id }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $inversion->nombre) }}">
        </div>

        <div class="form-group">
            <label class="form-label">Ubicación</label>
            <input type="text" name="ubicacion" class="form-control" value="{{ $inversion->ubicacion }}">
        </div>

        <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control">{{ $inversion->descripcion }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Cliente</label>
            <select name="cliente_id" class="form-control">
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}"
                        {{ $cliente->id == $inversion->cliente_id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">💾 Actualizar</button>
            <a href="/inversiones" class="btn-secondary">← Volver</a>
        </div>

    </form>

</div>

@endsection