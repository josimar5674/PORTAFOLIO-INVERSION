@extends('layouts.app')

@section('content')

@php

$totalPersonas =
    $clientes->count();

$naturales =
    $clientes->where('tipo','Natural')->count();

$juridicas =
    $clientes->where('tipo','Jurídico')->count();

@endphp

<div class="investment-header">

    <div>

        <h1>
            👥 Personas
        </h1>

        <small>

            {{ $totalPersonas }} registros

        </small>

    </div>

    <div>

        <a href="/clientes/create"
           class="btn-primary-custom">

            + Nueva Persona

        </a>

    </div>

</div>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="summary-grid">

    <div class="summary-card">

        👥 Total

        <strong>

            {{ $totalPersonas }}

        </strong>

    </div>

    <div class="summary-card">

        🧑 Naturales

        <strong>

            {{ $naturales }}

        </strong>

    </div>

    <div class="summary-card">

        🏢 Jurídicas

        <strong>

            {{ $juridicas }}

        </strong>

    </div>

</div>

<div style="margin-top:20px;">

    <input
        type="text"
        id="buscadorPersonas"
        class="form-control"
        placeholder="🔍 Buscar por nombre, email o teléfono...">

</div>

<div style="overflow-x:auto; margin-top:20px;">

<table class="table-dashboard">

    <thead>

        <tr>

            <th>Nombre</th>

            <th>Tipo</th>

            <th>Email</th>

            <th>Teléfono</th>

            <th>Acciones</th>

        </tr>

    </thead>

    <tbody id="tablaPersonas">

        @foreach($clientes as $cliente)

     <tr

    onclick="window.location='/clientes/{{ $cliente->id }}/edit'"

    style="cursor:pointer;">

            <td>

                <strong>

                    {{ $cliente->nombre }}

                </strong>

            </td>

            <td>

                {{ $cliente->tipo }}

            </td>

            <td>

                {{ $cliente->email }}

            </td>

            <td>

                {{ $cliente->telefono }}

            </td>

            <td>

                <a href="/clientes/{{ $cliente->id }}/edit"
                   class="btn-secondary">

                    Editar

                </a>

                <form method="POST"
                      action="/clientes/{{ $cliente->id }}"
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
    .getElementById(
        'buscadorPersonas'
    )
    .addEventListener(
        'keyup',
        function()
        {
            let filtro =
                this.value.toLowerCase();

            let filas =
                document.querySelectorAll(
                    '#tablaPersonas tr'
                );

            filas.forEach(
                fila =>
                {
                    let texto =
                        fila.innerText
                            .toLowerCase();

                    fila.style.display =
                        texto.includes(filtro)
                        ? ''
                        : 'none';
                }
            );
        }
    );

</script>

@endsection