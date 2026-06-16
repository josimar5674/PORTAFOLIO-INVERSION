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

<div style="
    max-width:900px;
">
            <!-- 🧑 PERFIL CLIENTE -->
            <div>
                <h3>Perfil de persona</h3>

                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control"
                        value="{{ old('nombre') }}">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ old('email') }}">
                </div>

             <div class="form-group">

    <label>
        Identificadores Tributarios
    </label>

    <div style="display:flex; gap:10px;">

        <input
            type="text"
            id="identificacionInput"
            class="form-control"
            placeholder="Ingrese identificador">

        <button
            type="button"
            onclick="agregarIdentificacion()"
            class="btn-primary-custom">

            ➕

        </button>

    </div>

    <ul id="listaIdentificaciones"
        style="margin-top:10px;">

    </ul>

</div>

                <div class="form-group">
                    <label>Móvil</label>
                    <input type="text" name="telefono" class="form-control"
                        value="{{ old('telefono') }}"
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
            class="form-control"
            placeholder="Ingrese nacionalidad">

        <button
            type="button"
            onclick="agregarNacionalidad()"
            class="btn-primary-custom">

            ➕

        </button>

    </div>

    <ul id="listaNacionalidades"
        style="margin-top:10px;">

    </ul>

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
       

        </div>

     


<!-- 🏢 ENTIDADES RELACIONADAS -->
<div>

    <h3>Entidades Relacionadas</h3>

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

    <ul id="listaEntidades"
        style="margin-top:10px;">

    </ul>

</div>

   <!-- BOTONES -->
        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">💾 Guardar</button>
            <a href="/clientes" class="btn-secondary">Cancelar</a>
        </div>

    </form>

</div>

<script>

let entidadesSeleccionadas = [];

function agregarEntidad()
{
    const select =
        document.getElementById('entidadSelect');

    const id =
        select.value;

    const nombre =
        select.options[
            select.selectedIndex
        ].text;

    if(!id) return;

    if(entidadesSeleccionadas.includes(id))
    {
        return;
    }

    entidadesSeleccionadas.push(id);

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
}

function eliminarEntidad(id, btn)
{
    entidadesSeleccionadas =
        entidadesSeleccionadas.filter(
            e => e != id
        );

    btn.closest('li').remove();
}


/*
|--------------------------------------------------------------------------
| IDENTIFICACIONES
|--------------------------------------------------------------------------
*/

let identificaciones = [];

function agregarIdentificacion()
{
    const input =
        document.getElementById(
            'identificacionInput'
        );

    const valor =
        input.value.trim();

    if(!valor) return;

    identificaciones.push(valor);

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

let nacionalidades = [];

function agregarNacionalidad()
{
    const input =
        document.getElementById(
            'nacionalidadInput'
        );

    const valor =
        input.value.trim();

    if(!valor) return;

    nacionalidades.push(valor);

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

</script>



@endsection