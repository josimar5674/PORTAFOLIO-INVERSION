@extends('layouts.app')

@section('content')

<div class="form-card">

    <!-- 🔙 VOLVER -->
    <div style="margin-bottom:10px;">
        <a href="/clientes" class="btn-secondary">
            ← Volver a Clientes
        </a>
    </div>

    <div class="form-title">
        ➕ Crear Cliente
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

    <form method="POST" action="/clientes">
        @csrf

        <!-- NOMBRE -->
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control"
                value="{{ old('nombre') }}" placeholder="Ej: Juan Pérez / Empresa XYZ">
        </div>

        <!-- TIPO -->
        <div class="form-group">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control"
                value="{{ old('tipo') }}" placeholder="Natural / Jurídico">
        </div>

        <!-- IDENTIFICACIÓN -->
        <div class="form-group">
            <label class="form-label">Identificación</label>
            <input type="text" name="identificacion" class="form-control"
                value="{{ old('identificacion') }}">
        </div>

        <!-- TELÉFONO -->
        <div class="form-group">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control"
                value="{{ old('telefono') }}">
        </div>

        <!-- EMAIL -->
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control"
                value="{{ old('email') }}">
        </div>

        <!-- BOTONES -->
        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">💾 Guardar</button>
            <a href="/clientes" class="btn-secondary">Cancelar</a>
        </div>

    </form>

</div>

@endsection