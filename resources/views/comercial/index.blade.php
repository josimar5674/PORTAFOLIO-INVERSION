@extends('layouts.app')

@section('content')

@php

$totalComercial =
    $items->sum('subtotal');

$totalRegistros =
    $items->count();

$totalClientes =
    $items->pluck('cliente')
          ->filter()
          ->unique()
          ->count();

@endphp

<div class="investment-header">

    <div>

        <h1>
            💰 Perfil Comercial
        </h1>

        <small>

            {{ $inversion->nombre }}

            ·

            {{ $totalRegistros }} registros

        </small>

    </div>

    <div>

        <a href="/inversiones/{{ $inversion->id }}"
           class="btn-secondary">

            ← Volver

        </a>

        <a href="/inversiones/{{ $inversion->id }}/comercial/create"
           class="btn-primary-custom">

            + Nuevo Registro

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

        📦 Productos

        <strong>

            {{ $totalRegistros }}

        </strong>

    </div>

    <div class="summary-card">

        👤 Clientes

        <strong>

            {{ $totalClientes }}

        </strong>

    </div>

    <div class="summary-card">

        💰 Total Comercial

        <strong>

            $ {{ number_format($totalComercial, 2) }}

        </strong>

    </div>

</div>

<div style="overflow-x:auto; margin-top:10px;">

<div style="margin-bottom:15px;">

    <input
        type="text"
        id="buscadorComercial"
        class="form-control"
        placeholder="🔍 Buscar producto, cliente o unidad..."
        onkeyup="filtrarComercial()">

</div>

<div style="
    margin-bottom:10px;
    color:#6b7280;
    font-size:14px;
">

    Registros encontrados:
    <span id="contadorResultados">
        {{ $items->count() }}
    </span>

</div>

<table class="table-dashboard">

    <thead>

        <tr>

            <th>Producto</th>

            <th>Cliente</th>

            <th>Cantidad</th>

            <th>Unidad</th>

            <th>Precio</th>

            <th>Subtotal</th>

            <th>Acciones</th>

        </tr>

    </thead>

<tbody id="tablaComercial">


    @foreach($items as $item)

        <tr>

            <td>

                <strong>

                    {{ $item->producto }}

                </strong>

            </td>

            <td>

                {{ $item->cliente }}

            </td>

            <td>

                {{ number_format($item->cantidad,2) }}

            </td>

            <td>

                {{ $item->unidad }}

            </td>

            <td>

                $ {{ number_format($item->precio_unitario,2) }}

            </td>

            <td style="font-weight:bold; color:#16a34a;">

                $ {{ number_format($item->subtotal,2) }}

            </td>

            <td>

                <a href="/inversiones/{{ $inversion->id }}/comercial/{{ $item->id }}/edit"
                   class="btn-secondary">

                    Ver

                </a>

                <form method="POST"
                      action="/inversiones/{{ $inversion->id }}/comercial/{{ $item->id }}"
                      style="display:inline;"
                      onsubmit="event.preventDefault(); confirmarEliminacion(this)">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
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

function filtrarComercial()
{
    let filtro =
        document.getElementById(
            'buscadorComercial'
        ).value.toLowerCase();

    let filas =
        document.querySelectorAll(
            '#tablaComercial tr'
        );

    let visibles = 0;

    filas.forEach(function(fila){

        let texto =
            fila.innerText.toLowerCase();

        let mostrar =
            texto.includes(filtro);

        fila.style.display =
            mostrar ? '' : 'none';

        if(mostrar){
            visibles++;
        }

    });

    document.getElementById(
        'contadorResultados'
    ).innerText = visibles;
}
</script>

@endsection