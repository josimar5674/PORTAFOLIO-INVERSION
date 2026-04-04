@extends('layouts.app')

@section('content')

<div class="form-card">

    <!-- 🔙 VOLVER -->
    <div style="margin-bottom:10px;">
        <a href="/inversiones/{{ $asset->investment_id }}/assets" class="btn-secondary">
            ← Volver a Activos
        </a>
    </div>

    <div class="form-title">✏️ Editar Activo</div>

    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/inversiones/{{ $asset->investment_id }}/assets/{{ $asset->id }}">
        @csrf
        @method('PUT')

        <input type="hidden" name="investment_id" value="{{ $asset->investment_id }}">

        <!-- NOMBRE -->
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control"
                value="{{ old('name', $asset->name) }}">
        </div>

        <!-- NIVEL -->
        <div class="form-group">
            <label class="form-label">Número de nivel</label>
            <input type="number" name="level_number" class="form-control"
                value="{{ old('level_number', $asset->level_number) }}">
        </div>

        <!-- TIPO -->
        <div class="form-group">
            <label class="form-label">Tipo</label>
            <input type="text" name="type" class="form-control"
                value="{{ old('type', $asset->type) }}">
        </div>

        <!-- ÁREA -->
        <div class="form-group">
            <label class="form-label">Área (m²)</label>
            <input type="number" step="0.01" name="area" class="form-control"
                value="{{ old('area', $asset->area) }}">
        </div>

        <!-- UNIDADES -->
        <div class="form-group">
            <label class="form-label">Cantidad de unidades</label>
            <input type="number" name="units" class="form-control"
                value="{{ old('units', $asset->units) }}">
        </div>

        <!-- DESCRIPCIÓN -->
        <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control">{{ old('description', $asset->description) }}</textarea>
        </div>

        <!-- ESTADO -->
        <div class="form-group">
            <label class="form-label">Estado</label>
            <select name="status" class="form-control">
                <option value="1" {{ old('status', $asset->status) == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ old('status', $asset->status) == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <!-- BOTONES -->
        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">💾 Actualizar</button>
            <a href="/inversiones/{{ $asset->investment_id }}/assets" class="btn-secondary">Cancelar</a>
        </div>

    </form>

</div>

@endsection