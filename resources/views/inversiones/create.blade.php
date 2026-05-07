@extends('layouts.app')

@section('content')

<div class="form-card">

    <div class="form-title">➕ Crear Inversión</div>

    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/inversiones">
        @csrf

        <!-- NOMBRE -->
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control"
                value="{{ old('nombre') }}" placeholder="Ej: Torre Norte">
        </div>

        <div class="form-group">
    <label class="form-label">Clave</label>
    <input type="text" name="clave" class="form-control"
        value="{{ old('clave') }}" placeholder="Ej: INV-001">
</div>

        <!-- UBICACIÓN -->
        <div class="form-group">
            <label class="form-label">Ubicación</label>
            <input type="text" name="ubicacion" class="form-control"
                value="{{ old('ubicacion') }}" placeholder="Ciudad, zona, etc.">
        </div>

        <!-- DESCRIPCIÓN -->
        <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control"
                placeholder="Detalles de la inversión...">{{ old('descripcion') }}</textarea>
        </div>

        <!-- CLIENTE -->
<div class="form-group">

    <label class="form-label">Personas relacionadas</label>

    <div style="display:flex; gap:10px;">

        <select id="clienteSelect" class="form-control">

            <option value="">-- Seleccionar Personas --</option>

            @foreach($clientes as $cliente)

                <option value="{{ $cliente->id }}">

                    {{ $cliente->nombre }}

                </option>

            @endforeach

        </select>

        <button type="button" onclick="agregarCliente()" class="btn-primary-custom">➕</button>

    </div>

    <!-- Lista de clientes agregados -->

    <ul id="listaClientes" style="margin-top:10px;"></ul>

</div>

<!-- ENTIDADES -->
<div class="form-group">

    <label class="form-label">Entidades relacionadas</label>

    <div style="display:flex; gap:10px;">

        <select id="entidadSelect" class="form-control">

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

    <!-- Lista -->
    <ul id="listaEntidades" style="margin-top:10px;"></ul>

</div>

        <!-- BOTONES -->
        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">💾 Guardar</button>
            <a href="/inversiones" class="btn-secondary">← Cancelar</a>
        </div>

    </form>

</div>

<script id="clientes-script">

let clientesSeleccionados = [];

function agregarCliente() {

    const select = document.getElementById('clienteSelect');
    const id = select.value;
    const nombre = select.options[select.selectedIndex].text;

    if (!id) return;

    // evitar duplicados
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

        <div style="display:flex; align-items:center; gap:8px;">
            <button type="button"
                onclick="eliminarCliente('${id}', this)"
                style="background:none; border:none; color:#ef4444; cursor:pointer; opacity:0.7;"
                onmouseover="this.style.opacity=1"
                onmouseout="this.style.opacity=0.7">
                🗑️
            </button>
        </div>

        <input type="hidden" name="clientes[]" value="${id}">
    `;

    lista.appendChild(li);
}

function eliminarCliente(id, btn) {
    clientesSeleccionados = clientesSeleccionados.filter(c => c != id);
    btn.closest('li').remove();
}




let entidadesSeleccionadas = [];

function agregarEntidad() {

    const select = document.getElementById('entidadSelect');

    const id = select.value;

    const nombre = select.options[select.selectedIndex].text;

    if (!id) return;

    // evitar duplicados
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

        <div style="display:flex; align-items:center; gap:8px;">

            <button type="button"
                onclick="eliminarEntidad('${id}', this)"
                style="background:none;
                       border:none;
                       color:#ef4444;
                       cursor:pointer;
                       opacity:0.7;"
                onmouseover="this.style.opacity=1"
                onmouseout="this.style.opacity=0.7">

                🗑️

            </button>

        </div>

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