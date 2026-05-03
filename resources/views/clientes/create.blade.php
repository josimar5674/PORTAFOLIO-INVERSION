@extends('layouts.app')

@section('content')

<div class="form-card">

    <!-- 🔙 VOLVER -->
    <div style="margin-bottom:10px;">
        <a href="/clientes" class="btn-secondary">
            ← Volver a personas
        </a>
    </div>

    <div class="form-title">
        ➕ Crear persona
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

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

            <!-- 🧑 PERFIL CLIENTE -->
            <div>
                <h3>Perfil de persona</h3>

                <div class="form-group">
                    <label>Nombre del Cliente</label>
                    <input type="text" name="nombre" class="form-control"
                        value="{{ old('nombre') }}">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label>Identificador Tributario</label>
                    <input type="text" name="identificacion" class="form-control"
                        value="{{ old('identificacion') }}"
                        inputmode="numeric" pattern="[0-9]*">
                </div>

                <div class="form-group">
                    <label>Móvil</label>
                    <input type="text" name="telefono" class="form-control"
                        value="{{ old('telefono') }}"
                        inputmode="numeric" pattern="[0-9]*"
                        placeholder="Ej: 99991234">
                </div>

                <div class="form-group">
                    <label>Nacionalidad</label>
                    <input type="text" name="nacionalidad" class="form-control"
                        value="{{ old('nacionalidad') }}">
                </div>

                <div class="form-group">
                    <label>Tipo</label>
                    <select name="tipo" class="form-control" required>
                        <option value="">Seleccione</option>
                        <option value="Natural" {{ old('tipo') == 'Natural' ? 'selected' : '' }}>Natural</option>
                        <option value="Jurídico" {{ old('tipo') == 'Jurídico' ? 'selected' : '' }}>Jurídico</option>
                    </select>
                </div>
            </div>

            <!-- 🏢 AGENTE RESIDENTE -->
            <div>
                <h3>Agente Residente</h3>

                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="agente_nombre" class="form-control"
                        value="{{ old('agente_nombre') }}">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="agente_email" class="form-control"
                        value="{{ old('agente_email') }}">
                </div>

                <div class="form-group">
                    <label>Número ID</label>
                    <input type="text" name="agente_numero_id" class="form-control"
                        value="{{ old('agente_numero_id') }}"
                        inputmode="numeric" pattern="[0-9]*">
                </div>

                <div class="form-group">
                    <label>Móvil</label>
                    <input type="text" name="agente_movil" class="form-control"
                        value="{{ old('agente_movil') }}"
                        inputmode="numeric" pattern="[0-9]*">
                </div>
                <div class="form-group">
                    <label>Tipo</label>
                    <select name="agente_tipo_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        <option value="Natural" {{ old('agente_tipo_id') == 'Natural' ? 'selected' : '' }}>Natural</option>
                        <option value="Jurídico" {{ old('agente_tipo_id') == 'Jurídico' ? 'selected' : '' }}>Jurídico</option>
                    </select>
                </div>
            </div>

        </div>

        <!-- BOTONES -->
        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">💾 Guardar</button>
            <a href="/clientes" class="btn-secondary">Cancelar</a>
        </div>

    </form>

</div>

@endsection