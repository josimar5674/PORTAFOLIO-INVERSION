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
        ✏️ Editar Servicio - {{ $servicio->clave ?? '' }}
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

        <!-- CLAVE -->
        <div class="form-group">
            <label>Clave</label>
            <input type="text" name="clave" class="form-control"
                value="{{ old('clave', $servicio->clave) }}">
        </div>

        <!-- PRESTADOR -->
        <div class="form-group">
            <label>Prestador</label>
            <input type="text" name="prestador" class="form-control"
                value="{{ old('prestador', $servicio->prestador) }}">
        </div>

        <!-- CATEGORÍA -->
        <div class="form-group">
            <label>Categoría</label>
            <input type="text" name="categoria" class="form-control"
                value="{{ old('categoria', $servicio->categoria) }}">
        </div>

        <!-- SERVICIO -->
        <div class="form-group">
            <label>Servicio</label>
            <input type="text" name="servicio" class="form-control"
                value="{{ old('servicio', $servicio->servicio) }}">
        </div>

        <!-- RELACIÓN -->
        <div class="form-group">
            <label>Relación</label>
            <input type="text" name="relacion" class="form-control"
                value="{{ old('relacion', $servicio->relacion) }}">
        </div>

        <!-- COSTO MENSUAL -->
        <div class="form-group">
            <label>Costo mensual</label>
            <input type="number" step="0.01" name="costo_mensual" class="form-control"
                value="{{ old('costo_mensual', $servicio->costo_mensual) }}"
                oninput="calcularAnual(this)">
        </div>

        <!-- COSTO ANUAL -->
        <div class="form-group">
            <label>Costo anual</label>
            <input type="number" step="0.01" name="costo_anual" class="form-control"
                value="{{ old('costo_anual', $servicio->costo_anual) }}" readonly>
        </div>

        <!-- BOTONES -->
        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">💾 Actualizar</button>
            <a href="/inversiones/{{ $servicio->inversion_id }}/servicios" class="btn-secondary">Cancelar</a>
        </div>

    </form>

</div>

<script>
function calcularAnual(input) {
    const mensual = parseFloat(input.value) || 0;
    const anual = mensual * 12;

    document.querySelector('input[name="costo_anual"]').value = anual.toFixed(2);
}
</script>

@endsection