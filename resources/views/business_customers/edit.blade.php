@extends('layouts.app')

@section('content')

<div class="form-card">

    <div class="form-title">

        ➕ Editar Cliente 

    </div>


    <div style="margin-bottom:15px;">

    <a href="/business-customers"
       class="btn-secondary">

        ← Volver a Clientes

    </a>

</div>  
    <form method="POST"
          action="/business-customers/{{ $cliente->id }}">

   @csrf
@method('PUT')

        <div class="form-group">

            <label>Nombre</label>

            <input
                type="text"
                name="nombre"
                class="form-control"
                value="{{ old('nombre', $cliente->nombre) }}"
            >
        </div>

        <div class="form-group">

            <label>Identificador Tributario</label>

            <input
                type="text"
                name="identificador_tributario"
                class="form-control"
                value="{{ old('identificador_tributario', $cliente->identificador_tributario) }}"
>
        </div>

        <div class="form-group">

            <label>Correo</label>

            <input
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email', $cliente->email) }}"
>
        </div>

        <div class="form-group">

            <label>Teléfono</label>

            <input
                type="text"
                name="telefono"
                class="form-control"
                value="{{ old('telefono', $cliente->telefono) }}"
            >
        </div>

        <hr>

        <h4>
            📝 Notas
        </h4>

        <div style="display:flex; gap:10px;">

            <input
                id="notaInput"
                class="form-control">

            <button
                type="button"
                class="btn-primary-custom"
                onclick="agregarNota()">

                ➕

            </button>

        </div>

<ul id="listaNotas"
    style="margin-top:15px;">

    @foreach($cliente->notas as $nota)

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

                {{ $nota->nota }}

            </span>

            <button
                type="button"
                onclick="this.parentElement.remove()"
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
                name="notas[]"
                value="{{ $nota->nota }}">

        </li>

    @endforeach

</ul>

        <div style="margin-top:20px;">

            <button
                class="btn-primary-custom">

                💾 Actualizar

            </button>

        </div>

    </form>



<h3>📄 Documentos</h3>

<form
    method="POST"
    action="/documentos"
    enctype="multipart/form-data">

    @csrf

    <input
        type="hidden"
        name="documentable_type"
        value="App\Models\BusinessCustomer">

    <input
        type="hidden"
        name="documentable_id"
        value="{{ $cliente->id }}">

    <input
        type="text"
        name="nombre"
        class="form-control"
        placeholder="Nombre documento">

    <input
        type="file"
        name="archivo"
        class="form-control">

    <button
        class="btn-primary-custom">

        Subir PDF

    </button>

</form>

@foreach($cliente->documentos as $documento)

<div class="card-item">

    📄 {{ $documento->nombre }}

    <a
        href="{{ asset('storage/'.$documento->archivo) }}"
        target="_blank">

        Ver

    </a>

</div>

@endforeach

<script>

function agregarNota()
{
    const input =
        document.getElementById('notaInput');

    const valor =
        input.value.trim();

    if(!valor) return;

    const lista =
        document.getElementById('listaNotas');

    const li =
        document.createElement('li');

    li.innerHTML = `
        ${valor}

        <input
            type="hidden"
            name="notas[]"
            value="${valor}">

        <button
            type="button"
            onclick="this.parentElement.remove()">

            🗑️

        </button>
    `;

    lista.appendChild(li);

    input.value='';
}

</script>
</div>
@endsection