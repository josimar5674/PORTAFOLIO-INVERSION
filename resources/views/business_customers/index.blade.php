@extends('layouts.app')

@section('content')

<div class="page-container">

    <h1 class="page-title">
        🏢 Clientes
    </h1>

</div>



<div class="investment-header">

    <div>

        <h1>
            👥 Clientes
        </h1>

     

    </div>

    <div>

        <a href="/business-customers/create"
           class="btn-primary-custom">

            + Nuevo cliente

        </a>

    </div>

</div>

<div style="margin-bottom:20px; display:flex; justify-content:space-between; gap:15px;">

    <input
        type="text"
        id="buscadorClientes"
        class="form-control"
        placeholder="Buscar cliente...">

 

</div>

<div style="overflow-x:auto; margin-top:20px;">

    <table class="table-dashboard"
           id="tablaClientes">

        <thead>

            <tr>

                <th>
                    Cliente
                </th>

                <th>
                    Identificador Tributario
                </th>

                <th>
                    Correo
                </th>

                <th>
                    Teléfono
                </th>

                <th>
                    Notas
                </th>

                <th>
                    Acciones
                </th>

            </tr>

        </thead>

        <tbody>

            @foreach($clientes as $cliente)

            <tr>

                <td>

                    <strong>

                        {{ $cliente->nombre }}

                    </strong>

                </td>

                <td>

                    {{ $cliente->identificador_tributario }}

                </td>

                <td>

                    {{ $cliente->email }}

                </td>

                <td>

                    {{ $cliente->telefono }}

                </td>

                <td>

                    {{ $cliente->notas->count() }}

                </td>

                <td>

                    <a href="/business-customers/{{ $cliente->id }}/edit"
                       class="btn-secondary">

                        Ver

                    </a>

                    <form
                        method="POST"
                        action="/business-customers/{{ $cliente->id }}"
                        style="display:inline;"
                        onsubmit="event.preventDefault(); confirmarEliminacion(this)">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn-danger">

                            🗑️

                        </button>

                    </form>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>


<script>

document
.getElementById('buscadorClientes')
.addEventListener('keyup', function(){

    let filtro =
        this.value.toLowerCase();

    document
    .querySelectorAll(
        '#tablaClientes tbody tr'
    )
    .forEach(fila => {

        fila.style.display =
            fila.innerText
                .toLowerCase()
                .includes(filtro)
            ? ''
            : 'none';

    });

});

</script>

@endsection