@extends('layouts.app')

@section('content')

<div class="form-card">

    <div class="form-title">
        ✏️ Editar Inversión
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

    <form method="POST" action="/inversiones/{{ $inversion->id }}">

        @csrf
        @method('PUT')

        <!-- NOMBRE -->
        <div class="form-group">

            <label class="form-label">
                Nombre
            </label>

            <input type="text"
                   name="nombre"
                   class="form-control"
                   value="{{ old('nombre', $inversion->nombre) }}">

        </div>

        <!-- UBICACIÓN -->
        <div class="form-group">

            <label class="form-label">
                Ubicación
            </label>

            <input type="text"
                   name="ubicacion"
                   class="form-control"
                   value="{{ old('ubicacion', $inversion->ubicacion) }}">

        </div>

        <!-- DESCRIPCIÓN -->
        <div class="form-group">

            <label class="form-label">
                Descripción
            </label>

            <textarea name="descripcion"
                      class="form-control">{{ old('descripcion', $inversion->descripcion) }}</textarea>

        </div>

        <!-- CLIENTES -->
        <div class="form-group">

            <label class="form-label">
                Personas relacionadas
            </label>

            <div style="display:flex; gap:10px;">

                <select id="clienteSelect"
                        class="form-control">

                    <option value="">
                        -- Seleccionar Personas --
                    </option>

                    @foreach($clientes as $cliente)

                        <option value="{{ $cliente->id }}">

                            {{ $cliente->nombre }}

                        </option>

                    @endforeach

                </select>

                <button type="button"
                        onclick="agregarCliente()"
                        class="btn-primary-custom">

                    ➕

                </button>

            </div>

            <!-- LISTA -->
            <ul id="listaClientes"
                style="margin-top:10px;">

                @foreach($inversion->clientes as $cliente)

                    <li style="
                        display:flex;
                        justify-content:space-between;
                        align-items:center;
                        padding:6px 10px;
                        background:#f9fafb;
                        border-radius:6px;
                        margin-bottom:6px;
                    ">

                        <span>
                            {{ $cliente->nombre }}
                        </span>

                        <button type="button"
                            onclick="eliminarCliente('{{ $cliente->id }}', this)"
                            style="
                                background:none;
                                border:none;
                                color:#ef4444;
                                cursor:pointer;
                            ">

                            🗑️

                        </button>

                        <input type="hidden"
                               name="clientes[]"
                               value="{{ $cliente->id }}">

                    </li>

                @endforeach

            </ul>

        </div>

        <!-- ENTIDADES -->
        <div class="form-group">

            <label class="form-label">
                Entidades relacionadas
            </label>

            <div style="display:flex; gap:10px;">

                <select id="entidadSelect"
                        class="form-control">

                    <option value="">
                        -- Seleccionar Entidad --
                    </option>

                    @foreach($entidades as $entidad)

                        <option value="{{ $entidad->id }}">

                            {{ $entidad->denominacion_social }}

                        </option>

                    @endforeach

                </select>

                <button type="button"
                        onclick="agregarEntidad()"
                        class="btn-primary-custom">

                    ➕

                </button>

            </div>

            <!-- LISTA -->
            <ul id="listaEntidades"
                style="margin-top:10px;">

                @foreach($inversion->entidades as $entidad)

                    <li style="
                        display:flex;
                        justify-content:space-between;
                        align-items:center;
                        padding:6px 10px;
                        background:#f9fafb;
                        border-radius:6px;
                        margin-bottom:6px;
                    ">

                        <span>
                            {{ $entidad->denominacion_social }}
                        </span>

                        <button type="button"
                            onclick="eliminarEntidad('{{ $entidad->id }}', this)"
                            style="
                                background:none;
                                border:none;
                                color:#ef4444;
                                cursor:pointer;
                            ">

                            🗑️

                        </button>

                        <input type="hidden"
                               name="entidades[]"
                               value="{{ $entidad->id }}">

                    </li>

                @endforeach

            </ul>

        </div>

        <!-- BOTONES -->
        <div style="margin-top:20px;">

            <button type="submit"
                    class="btn-primary-custom">

                💾 Actualizar

            </button>

            <a href="/inversiones"
               class="btn-secondary">

                ← Volver

            </a>

        </div>

    </form>

</div>

<!-- SCRIPTS -->
<script>

let clientesSeleccionados = [

    @foreach($inversion->clientes as $cliente)

        "{{ $cliente->id }}",

    @endforeach

];

function agregarCliente() {

    const select = document.getElementById('clienteSelect');

    const id = select.value;

    const nombre = select.options[select.selectedIndex].text;

    if (!id) return;

    if (clientesSeleccionados.includes(id)) return;

    clientesSeleccionados.push(id);

    const lista = document.getElementById('listaClientes');

    const li = document.createElement('li');

    li.style.display = "flex";
    li.style.justifyContent = "space-between";
    li.style.alignItems = "center";
    li.style.padding = "6px 10px";
    li.style.background = "#f9fafb";
    li.style.borderRadius = "6px";
    li.style.marginBottom = "6px";

    li.innerHTML = `
        <span>${nombre}</span>

        <button type="button"
            onclick="eliminarCliente('${id}', this)"
            style="
                background:none;
                border:none;
                color:#ef4444;
                cursor:pointer;
            ">

            🗑️

        </button>

        <input type="hidden"
               name="clientes[]"
               value="${id}">
    `;

    lista.appendChild(li);
}

function eliminarCliente(id, btn) {

    clientesSeleccionados =
        clientesSeleccionados.filter(c => c != id);

    btn.closest('li').remove();
}

let entidadesSeleccionadas = [

    @foreach($inversion->entidades as $entidad)

        "{{ $entidad->id }}",

    @endforeach

];

function agregarEntidad() {

    const select = document.getElementById('entidadSelect');

    const id = select.value;

    const nombre = select.options[select.selectedIndex].text;

    if (!id) return;

    if (entidadesSeleccionadas.includes(id)) return;

    entidadesSeleccionadas.push(id);

    const lista = document.getElementById('listaEntidades');

    const li = document.createElement('li');

    li.style.display = "flex";
    li.style.justifyContent = "space-between";
    li.style.alignItems = "center";
    li.style.padding = "6px 10px";
    li.style.background = "#f9fafb";
    li.style.borderRadius = "6px";
    li.style.marginBottom = "6px";

    li.innerHTML = `
        <span>${nombre}</span>

        <button type="button"
            onclick="eliminarEntidad('${id}', this)"
            style="
                background:none;
                border:none;
                color:#ef4444;
                cursor:pointer;
            ">

            🗑️

        </button>

        <input type="hidden"
               name="entidades[]"
               value="${id}">
    `;

    lista.appendChild(li);
}

function eliminarEntidad(id, btn) {

    entidadesSeleccionadas =
        entidadesSeleccionadas.filter(e => e != id);

    btn.closest('li').remove();
}

</script>

@endsection