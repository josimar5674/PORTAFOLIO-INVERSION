@extends('layouts.app')

@section('content')

<div class="form-card">

    <!<!-- 🔙 VOLVER -->
<div style="margin-bottom:10px;">
    <a href="/inversiones/{{ $item->inversion_id }}/comercial" class="btn-secondary">
        ← Volver a Comercial
    </a>
</div>

<div class="form-title">
    ✏️ Editar Registro - {{ $item->producto ?? '' }}
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

<form method="POST" action="/inversiones/{{ $item->inversion_id }}/comercial/{{ $item->id }}">
    @csrf
    @method('PUT')

    <input type="hidden" name="inversion_id" value="{{ $item->inversion_id }}">

    <!-- PRODUCTO -->
    <div class="form-group">
        <label>Producto</label>
        <input type="text" name="producto" class="form-control"
            value="{{ old('producto', $item->producto) }}">
    </div>

    <!-- CLIENTE -->
    <div class="form-group">
        <label>Cliente</label>
        <input type="text" name="cliente" class="form-control"
            value="{{ old('cliente', $item->cliente) }}">
    </div>

    <!-- CANTIDAD -->
    <div class="form-group">
        <label>Cantidad</label>
        <input type="number" step="0.01" name="cantidad" class="form-control"
            value="{{ old('cantidad', $item->cantidad) }}"
            oninput="calcularSubtotal()">
    </div>

    <!-- UNIDAD -->
    <div class="form-group">
        <label>Unidad</label>
        <input type="text" name="unidad" class="form-control"
            value="{{ old('unidad', $item->unidad) }}">
    </div>

    <!-- PRECIO -->
    <div class="form-group">
        <label>Precio Unitario</label>
        <input type="number" step="0.01" name="precio" class="form-control"
            value="{{ old('precio', $item->precio_unitario) }}"
            oninput="calcularSubtotal()">
    </div>

    <!-- SUBTOTAL -->
    <div class="form-group">
        <label>Subtotal</label>
        <input type="number" step="0.01" name="subtotal" class="form-control"
            value="{{ old('subtotal', $item->subtotal) }}" readonly>
    </div>

    <!-- BOTONES -->
    <div style="margin-top:20px; display:flex; justify-content:space-between;">

        <a href="/inversiones/{{ $item->inversion_id }}/comercial" class="btn-secondary">
            ← Cancelar
        </a>

        <button type="submit" class="btn-primary-custom">
            💾 Actualizar
        </button>

    </div>

</form>

</div>

<script>
function calcularSubtotal() {
    const cantidad = parseFloat(document.querySelector('[name="cantidad"]').value) || 0;
    const precio = parseFloat(document.querySelector('[name="precio"]').value) || 0;

    const subtotal = cantidad * precio;

    document.querySelector('[name="subtotal"]').value = subtotal.toFixed(2);
}
</script>


@endsection