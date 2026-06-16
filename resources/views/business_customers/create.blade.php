@extends('layouts.app')

@section('content')

<div class="form-card">

    <div class="form-title">

        ➕ Nuevo Cliente

        

    </div>



    <div style="margin-bottom:15px;">

    <a href="/business-customers"
       class="btn-secondary">

        ← Volver a Clientes

    </a>

</div>
    
    

    <form method="POST"
          action="/business-customers">

        @csrf

        <div class="form-group">

            <label>Nombre</label>

            <input
                type="text"
                name="nombre"
                class="form-control">

        </div>

        <div class="form-group">

            <label>Identificador Tributario</label>

            <input
                type="text"
                name="identificador_tributario"
                class="form-control">

        </div>

        <div class="form-group">

            <label>Correo</label>

            <input
                type="email"
                name="email"
                class="form-control">

        </div>

        <div class="form-group">

            <label>Teléfono</label>

            <input
                type="text"
                name="telefono"
                class="form-control">

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
            style="margin-top:15px;"></ul>

        <div style="margin-top:20px;">

            <button
                class="btn-primary-custom">

                💾 Guardar

            </button>

        </div>

    </form>

</div>

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

@endsection