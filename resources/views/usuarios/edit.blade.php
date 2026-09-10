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


        <!-- ===================================================== -->
        <!-- PERMISOS -->
        <!-- ===================================================== -->

        <div id="permisosContainer">

            <!-- PESTAÑAS -->

      <!-- PESTAÑAS -->

<!-- PESTAÑAS -->

<div class="permission-tabs">

    <button type="button"
            id="tabInversiones"
            class="permission-tab active"
            onclick="mostrarPermisos('inversiones')">

        🏢 Inversiones

    </button>


    <button type="button"
            id="tabClientes"
            class="permission-tab"
            onclick="mostrarPermisos('clientes')">

        👤 Clientes

    </button>

</div>


            <!-- ================================================= -->
            <!-- INVERSIONES -->
            <!-- ================================================= -->

            <div id="permisos-inversiones">

                <div class="form-group">

                    <label class="form-label">

                        Inversiones Permitidas

                    </label>


                    @foreach($inversiones as $inversion)

                        @php
                            $permiso = $permisos[$inversion->id] ?? null;
                        @endphp


                        <div style="
                            border:1px solid #ddd;
                            padding:15px;
                            border-radius:8px;
                            margin-bottom:15px;
                        ">

                            <!-- INVERSIÓN -->

                            <label>

                                <input type="checkbox"
                                       name="inversiones[]"
                                       value="{{ $inversion->id }}"
                                       {{ in_array($inversion->id, $inversionesUsuario) ? 'checked' : '' }}>

                                <strong>

                                    {{ $inversion->nombre }}

                                </strong>

                            </label>


                            <!-- MÓDULOS -->

                            <div style="
                                margin-top:10px;
                                margin-left:25px;
                                display:grid;
                                grid-template-columns:repeat(3,1fr);
                                gap:8px;
                            ">


                                <!-- AVALÚOS -->

                                <label>

                                    <input type="checkbox"
                                           name="permisos[{{ $inversion->id }}][avaluos]"
                                           {{ $permiso && $permiso->avaluos ? 'checked' : '' }}>

                                    Avalúos

                                </label>


                                <!-- ACTIVOS -->

                                <label>

                                    <input type="checkbox"
                                           name="permisos[{{ $inversion->id }}][activos]"
                                           {{ $permiso && $permiso->activos ? 'checked' : '' }}>

                                    Activos

                                </label>


                                <!-- SERVICIOS -->

                                <label>

                                    <input type="checkbox"
                                           name="permisos[{{ $inversion->id }}][servicios]"
                                           {{ $permiso && $permiso->servicios ? 'checked' : '' }}>

                                    Servicios

                                </label>


                                <!-- COMERCIAL -->

                                <label>

                                    <input type="checkbox"
                                           name="permisos[{{ $inversion->id }}][comercial]"
                                           {{ $permiso && $permiso->comercial ? 'checked' : '' }}>

                                    Comercial

                                </label>


                                <!-- ENTIDADES -->

                                <label>

                                    <input type="checkbox"
                                           name="permisos[{{ $inversion->id }}][entidades]"
                                           {{ $permiso && $permiso->entidades ? 'checked' : '' }}>

                                    Entidades

                                </label>


                                <!-- ESTADO RESULTADOS -->

                                <label>

                                    <input type="checkbox"
                                           name="permisos[{{ $inversion->id }}][estado_resultados]"
                                           {{ $permiso && $permiso->estado_resultados ? 'checked' : '' }}>

                                    Estado Resultados

                                </label>


                                <!-- BITÁCORAS -->

                                <label>

                                    <input type="checkbox"
                                           name="permisos[{{ $inversion->id }}][bitacoras]"
                                           {{ $permiso && $permiso->bitacoras ? 'checked' : '' }}>

                                    Bitácoras

                                </label>


                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

<!-- ================================================= -->
<!-- BUSINESS CUSTOMERS -->
<!-- ================================================= -->

<div id="permisos-clientes"
     style="display:none;">

    <div class="form-group">

        <label class="form-label">
            Business Customers Permitidos
        </label>


        @if($businessCustomers->count())

            <div style="
                display:grid;
                grid-template-columns:repeat(2, minmax(0, 1fr));
                gap:12px;
            ">

                @foreach($businessCustomers as $businessCustomer)

                    <label
                        style="
                            display:flex !important;
                            align-items:center !important;
                            gap:12px !important;

                            width:100% !important;
                            box-sizing:border-box !important;

                            padding:14px 16px !important;

                            border:1px solid #3a465c !important;
                            border-radius:10px !important;

                            background:rgba(255,255,255,0.02) !important;

                            cursor:pointer !important;

                            margin:0 !important;

                            overflow:hidden !important;
                        "
                    >

                        <!-- CHECKBOX -->

                        <input
                            type="checkbox"
                            name="business_customers[]"
                            value="{{ $businessCustomer->id }}"
                            {{ in_array(
                                $businessCustomer->id,
                                $businessCustomersUsuario
                            ) ? 'checked' : '' }}

                            style="
                                flex:0 0 auto !important;
                                width:16px !important;
                                height:16px !important;
                                margin:0 !important;
                            "
                        >


                        <!-- INFORMACIÓN -->

                        <div style="
                            min-width:0;
                            flex:1;
                            overflow:hidden;
                        ">

                            <div style="
                                font-weight:600;
                                font-size:15px;
                                white-space:nowrap;
                                overflow:hidden;
                                text-overflow:ellipsis;
                            ">

                                {{ $businessCustomer->nombre }}

                            </div>


                            @if($businessCustomer->identificador_tributario)

                                <div style="
                                    margin-top:4px;
                                    font-size:12px;
                                    opacity:.65;
                                    white-space:nowrap;
                                    overflow:hidden;
                                    text-overflow:ellipsis;
                                ">

                                    ID:
                                    {{ $businessCustomer->identificador_tributario }}

                                </div>

                            @endif

                        </div>

                    </label>

                @endforeach

            </div>

        @else

            <div style="
                padding:20px;
                border:1px dashed #555;
                border-radius:10px;
                text-align:center;
                opacity:.7;
            ">

                No hay Business Customers registrados.

            </div>

        @endif

    </div>

</div>
        <!-- ===================================================== -->
        <!-- ESTADO -->
        <!-- ===================================================== -->

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


        <!-- ===================================================== -->
        <!-- BOTONES -->
        <!-- ===================================================== -->

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


<!-- ============================================================= -->
<!-- JAVASCRIPT DE PESTAÑAS -->
<!-- ============================================================= -->
<script>

function mostrarPermisos(tipo)
{
    const inversiones =
        document.getElementById('permisos-inversiones');

    const clientes =
        document.getElementById('permisos-clientes');

    const tabInversiones =
        document.getElementById('tabInversiones');

    const tabClientes =
        document.getElementById('tabClientes');


    if (tipo === 'inversiones') {

        inversiones.style.display = 'block';

        clientes.style.display = 'none';

        tabInversiones.classList.add('active');

        tabClientes.classList.remove('active');

    }


    if (tipo === 'clientes') {

        inversiones.style.display = 'none';

        clientes.style.display = 'block';

        tabInversiones.classList.remove('active');

        tabClientes.classList.add('active');

    }
}

</script>

@endsection