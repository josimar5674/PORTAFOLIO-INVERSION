@extends('layouts.app')

@section('content')

<div class="form-card">

    <!-- 🔙 VOLVER -->
    <div style="margin-bottom:10px;">
        <a href="/clientes" class="btn-secondary">
            ← Volver 
        </a>
    </div>

    <div class="form-title">
        ✏️ Editar Persona - {{ $cliente->nombre }}
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

    <form method="POST" action="/clientes/{{ $cliente->id }}">
        @csrf
        @method('PUT')

  
<div style="
    max-width:900px;
    margin:auto;
">
    <!-- 🧑 PERFIL CLIENTE -->
    <div>
        <h3>Perfil </h3>

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control"
                value="{{ old('nombre', $cliente->nombre) }}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                value="{{ old('email', $cliente->email) }}">
        </div>

     <div class="form-group">

    <label>
        Identificadores Tributarios
    </label>

    <div style="display:flex; gap:10px;">

        <input
            type="text"
            id="identificacionInput"
            class="form-control">

        <button
            type="button"
            onclick="agregarIdentificacion()"
            class="btn-primary-custom">

            ➕

        </button>

    </div>

    <ul id="listaIdentificaciones"
        style="margin-top:10px;">

        @foreach($cliente->identificaciones as $identificacion)

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
                    {{ $identificacion->numero }}
                </span>

                <button
                    type="button"
                    onclick="eliminarIdentificacion(this)"
                    style="
                        background:none;
                        border:none;
                        color:#ef4444;
                        cursor:pointer;
                    ">
                    🗑️
                </button>

                <input
                    type="hidden"
                    name="identificaciones[]"
                    value="{{ $identificacion->numero }}">

            </li>

        @endforeach

    </ul>

</div>

        <div class="form-group">
            <label>Móvil</label>
            <input type="text" name="telefono" class="form-control"
                value="{{ old('telefono', $cliente->telefono) }}"
                inputmode="numeric" pattern="[0-9]*"
                placeholder="Ej: 99991234">
        </div>

   <div class="form-group">

    <label>
        Nacionalidades
    </label>

    <div style="display:flex; gap:10px;">

        <input
            type="text"
            id="nacionalidadInput"
            class="form-control">

        <button
            type="button"
            onclick="agregarNacionalidad()"
            class="btn-primary-custom">

            ➕

        </button>

    </div>

    <ul id="listaNacionalidades"
        style="margin-top:10px;">

        @foreach($cliente->nacionalidades as $nacionalidad)

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
                    {{ $nacionalidad->pais }}
                </span>

                <button
                    type="button"
                    onclick="eliminarNacionalidad(this)"
                    style="
                        background:none;
                        border:none;
                        color:#ef4444;
                        cursor:pointer;
                    ">
                    🗑️
                </button>

                <input
                    type="hidden"
                    name="nacionalidades[]"
                    value="{{ $nacionalidad->pais }}">

            </li>

        @endforeach

    </ul>

</div>

        <!-- 🔥 Tipo (igual que create pero con valor) -->

    <label>
        Tipo
    </label>

<div style="display:flex; gap:10px;">

            <select name="tipo" class="form-control" required>


    <option value="">Seleccione</option>
                <option value="Natural" {{ old('tipo', $cliente->tipo) == 'Natural' ? 'selected' : '' }}>Natural</option>
                <option value="Jurídico" {{ old('tipo', $cliente->tipo) == 'Jurídico' ? 'selected' : '' }}>Jurídico</option>

 
    </select>



</div>



    <!-- 🏢 AGENTE RESIDENTE -->


<h3>
    Entidades Relacionadas
</h3>

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

    <button
        type="button"
        onclick="agregarEntidad()"
        class="btn-primary-custom">

        ➕

    </button>

</div>

<ul id="listaEntidades"
    style="margin-top:10px;">

    @foreach($cliente->entidades as $entidad)

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

            <button
                type="button"
                onclick="eliminarEntidad('{{ $entidad->id }}', this)"
                style="
                    background:none;
                    border:none;
                    color:#ef4444;
                    cursor:pointer;
                ">
                🗑️
            </button>

            <input
                type="hidden"
                name="entidades[]"
                value="{{ $entidad->id }}">

        </li>

    @endforeach

</ul>
        <!-- BOTONES -->
        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">💾 Actualizar</button>
            <a href="/clientes" class="btn-secondary">Cancelar</a>
        </div>

    </form>

</div>

<script>

let entidadesSeleccionadas =
    @json($cliente->entidades->pluck('id'));

/*
|--------------------------------------------------------------------------
| IDENTIFICACIONES
|--------------------------------------------------------------------------
*/

function agregarIdentificacion()
{
    const input =
        document.getElementById(
            'identificacionInput'
        );

    const valor =
        input.value.trim();

    if(!valor) return;

    const lista =
        document.getElementById(
            'listaIdentificaciones'
        );

    const li =
        document.createElement('li');

    li.style.display = "flex";
    li.style.justifyContent = "space-between";
    li.style.alignItems = "center";
    li.style.padding = "6px 10px";
    li.style.background = "#f9fafb";
    li.style.borderRadius = "6px";
    li.style.marginBottom = "6px";

    li.innerHTML = `
        <span>${valor}</span>

        <button
            type="button"
            onclick="eliminarIdentificacion(this)"
            style="
                background:none;
                border:none;
                color:#ef4444;
                cursor:pointer;
            ">
            🗑️
        </button>

        <input
            type="hidden"
            name="identificaciones[]"
            value="${valor}">
    `;

    lista.appendChild(li);

    input.value = '';
}

function eliminarIdentificacion(btn)
{
    btn.closest('li').remove();
}

/*
|--------------------------------------------------------------------------
| NACIONALIDADES
|--------------------------------------------------------------------------
*/

function agregarNacionalidad()
{
    const input =
        document.getElementById(
            'nacionalidadInput'
        );

    const valor =
        input.value.trim();

    if(!valor) return;

    const lista =
        document.getElementById(
            'listaNacionalidades'
        );

    const li =
        document.createElement('li');

    li.style.display = "flex";
    li.style.justifyContent = "space-between";
    li.style.alignItems = "center";
    li.style.padding = "6px 10px";
    li.style.background = "#f9fafb";
    li.style.borderRadius = "6px";
    li.style.marginBottom = "6px";

    li.innerHTML = `
        <span>${valor}</span>

        <button
            type="button"
            onclick="eliminarNacionalidad(this)"
            style="
                background:none;
                border:none;
                color:#ef4444;
                cursor:pointer;
            ">
            🗑️
        </button>

        <input
            type="hidden"
            name="nacionalidades[]"
            value="${valor}">
    `;

    lista.appendChild(li);

    input.value = '';
}

function eliminarNacionalidad(btn)
{
    btn.closest('li').remove();
}

/*
|--------------------------------------------------------------------------
| ENTIDADES
|--------------------------------------------------------------------------
*/

function agregarEntidad()
{
    const select =
        document.getElementById(
            'entidadSelect'
        );

    const id =
        select.value;

    const nombre =
        select.options[
            select.selectedIndex
        ].text;

    if(!id) return;

    if(
        entidadesSeleccionadas.includes(
            parseInt(id)
        )
    )
    {
        return;
    }

    entidadesSeleccionadas.push(
        parseInt(id)
    );

    const lista =
        document.getElementById(
            'listaEntidades'
        );

    const li =
        document.createElement('li');

    li.style.display = "flex";
    li.style.justifyContent = "space-between";
    li.style.alignItems = "center";
    li.style.padding = "6px 10px";
    li.style.background = "#f9fafb";
    li.style.borderRadius = "6px";
    li.style.marginBottom = "6px";

    li.innerHTML = `
        <span>${nombre}</span>

        <button
            type="button"
            onclick="eliminarEntidad('${id}', this)"
            style="
                background:none;
                border:none;
                color:#ef4444;
                cursor:pointer;
            ">
            🗑️
        </button>

        <input
            type="hidden"
            name="entidades[]"
            value="${id}">
    `;

    lista.appendChild(li);

    select.value = '';
}

function eliminarEntidad(id, btn)
{
    entidadesSeleccionadas =
        entidadesSeleccionadas.filter(
            e => e != id
        );

    btn.closest('li').remove();
}

</script>

@endsection