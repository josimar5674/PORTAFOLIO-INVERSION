@extends('layouts.app')

@section('content')

<div class="form-card">

    <!-- TITULO -->
    <div class="form-title">

        👤 Editar Usuario

    </div>

    @if ($errors->any())

        <div class="error-box">

            <ul style="margin:0; padding-left:20px;">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form method="POST"
          action="/usuarios/{{ $usuario->id }}">

        @csrf
        @method('PUT')

        <!-- NOMBRE -->
        <div class="form-group">

            <label class="form-label">

                Nombre

            </label>

            <input type="text"
                   class="form-control"
                   value="{{ $usuario->name }}"
                   disabled>

        </div>

        <!-- EMAIL -->
        <div class="form-group">

            <label class="form-label">

                Correo Electrónico

            </label>

            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email', $usuario->email) }}">

        </div>

        <!-- ROL -->
        <div class="form-group">

            <label class="form-label">

                Rol

            </label>

            <select name="role"
                    class="form-control">

                <option value="user"
                    {{ $usuario->role == 'user' ? 'selected' : '' }}>

                    Usuario

                </option>

                <option value="admin"
                    {{ $usuario->role == 'admin' ? 'selected' : '' }}>

                    Administrador

                </option>

            </select>

        </div>

        <!-- ESTADO -->
        <div class="form-group">

            <label class="form-label">

                Estado

            </label>

       <select name="estado"
        class="form-control">

    <option value="1"
        {{ $usuario->estado ? 'selected' : '' }}>

        Activo

    </option>

    <option value="0"
        {{ !$usuario->estado ? 'selected' : '' }}>

        Inactivo

    </option>

</select>

        </div>

        <!-- BOTONES -->
        <div style="
            display:flex;
            gap:15px;
            margin-top:25px;
        ">

            <button type="submit"
                    class="btn-primary-custom">

                💾 Actualizar Usuario

            </button>

            <a href="/usuarios"
               class="btn-secondary">

                Cancelar

            </a>

        </div>

    </form>

</div>

@endsection