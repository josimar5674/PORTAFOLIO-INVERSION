@extends('layouts.app')

@section('content')

<div class="form-card">

    <!-- TITULO -->
    <div class="form-title">

        👤 Crear Usuario

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
          action="/usuarios">

        @csrf

        <!-- NOMBRE -->
        <div class="form-group">

            <label class="form-label">

                Nombre Completo

            </label>

            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name') }}"
                   required>

        </div>

        <!-- EMAIL -->
        <div class="form-group">

            <label class="form-label">

                Correo Electrónico

            </label>

            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email') }}"
                   required>

        </div>

        <!-- PASSWORD -->
        <div class="form-group">

            <label class="form-label">

                Contraseña

            </label>

            <input type="password"
                   name="password"
                   class="form-control"
                   required>

        </div>

        <!-- ROL -->
        <div class="form-group">

            <label class="form-label">

                Rol

            </label>

            <select name="role"
                    class="form-control">

                <option value="user">

                    Usuario

                </option>

                <option value="admin">

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

                <option value="1" selected>

                    Activo

                </option>

                <option value="0">

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

                💾 Guardar Usuario

            </button>

            <a href="/usuarios"
               class="btn-secondary">

                Cancelar

            </a>

        </div>

    </form>

</div>

@endsection