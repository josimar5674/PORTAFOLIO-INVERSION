
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

        <!-- INVERSIONES -->
<div id="permisosContainer"
     style="display:none;">

    <div class="form-group">

        <label class="form-label">

            Inversiones Permitidas

        </label>

        @foreach($inversiones as $inversion)

            <div style="
                border:1px solid #ddd;
                padding:15px;
                border-radius:8px;
                margin-bottom:15px;
            ">

                <label>

                    <input type="checkbox"
                           name="inversiones[]"
                           value="{{ $inversion->id }}">

                    <strong>

                        {{ $inversion->nombre }}

                    </strong>

                </label>

                <div style="
                    margin-top:10px;
                    margin-left:25px;
                    display:grid;
                    grid-template-columns:repeat(3,1fr);
                    gap:8px;
                ">

                    <label>
                        <input type="checkbox"
                               name="permisos[{{ $inversion->id }}][avaluos]">

                        Avalúos
                    </label>

                    <label>
                        <input type="checkbox"
                               name="permisos[{{ $inversion->id }}][activos]">

                        Activos
                    </label>

                    <label>
                        <input type="checkbox"
                               name="permisos[{{ $inversion->id }}][servicios]">

                        Servicios
                    </label>

                    <label>
                        <input type="checkbox"
                               name="permisos[{{ $inversion->id }}][comercial]">

                        Comercial
                    </label>

                    <label>
                        <input type="checkbox"
                               name="permisos[{{ $inversion->id }}][entidades]">

                        Entidades
                    </label>

                    <label>
                        <input type="checkbox"
                               name="permisos[{{ $inversion->id }}][estado_resultados]">

                        Estado Resultados
                    </label>

                    <label>
    <input type="checkbox"
           name="permisos[{{ $inversion->id }}][activos_registrales]">

    Activos Registrales
</label>

                </div>

            </div>

        @endforeach

    </div>

</div>
        <div class="form-group">

            <label class="form-label">

                Rol

            </label>

           <select name="role"
        id="role"
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

<script>

const roleSelect =
    document.getElementById('role');

const permisosContainer =
    document.getElementById('permisosContainer');

function actualizarPermisos()
{
    if(roleSelect.value === 'user')
    {
        permisosContainer.style.display = 'block';
    }
    else
    {
        permisosContainer.style.display = 'none';
    }
}

roleSelect.addEventListener(
    'change',
    actualizarPermisos
);

actualizarPermisos();

</script>

@endsection