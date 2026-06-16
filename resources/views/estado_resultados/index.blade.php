@extends('layouts.app')

@section('content')

@php

$totalEstados =
    $estados->count();

$ultimaUtilidad =
    $estados->first()?->utilidad_neta ?? 0;

$ultimoNOI =
    $estados->first()?->noi ?? 0;

$ultimoEBIT =
    $estados->first()?->ebit ?? 0;

@endphp

<div class="investment-header">

    <div>

        <h1>
            📊 Estado de Resultados
        </h1>

        <small>

            {{ $inversion->nombre }}

            ·

            {{ $totalEstados }} registros

        </small>

    </div>

    <div>

        <a href="/inversiones/{{ $inversion->id }}"
           class="btn-secondary">

            ← Volver

        </a>

        <button
            type="button"
            class="btn-primary-custom"
            onclick="abrirModalGenerar()">

            ⚙️ Generar Estado

        </button>

    </div>

</div>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="summary-grid">

    <div class="summary-card">

        📄 Estados

        <strong>

            {{ $totalEstados }}

        </strong>

    </div>

    <div class="summary-card">

        📊 NOI

        <strong>

            $ {{ number_format($ultimoNOI,2) }}

        </strong>

    </div>

    <div class="summary-card">

        📈 EBIT

        <strong>

            $ {{ number_format($ultimoEBIT,2) }}

        </strong>

    </div>

    <div class="summary-card">

        🏆 Utilidad Neta

        <strong>

            $ {{ number_format($ultimaUtilidad,2) }}

        </strong>

    </div>

</div>

<div style="overflow-x:auto; margin-top:25px;">

<table class="table-dashboard">

    <thead>

        <tr>

            <th>Año</th>

            <th>Ingresos</th>

            <th>Costos</th>

            <th>NOI</th>

            <th>EBIT</th>

            <th>EBT</th>

            <th>Impuestos</th>

            <th>Utilidad Neta</th>

            <th>Acciones</th>

        </tr>

    </thead>

    <tbody>

    @foreach($estados as $estado)

        <tr>

            <td>

                <strong>

                    {{ $estado->anio }}

                </strong>

            </td>

            <td>

                $ {{ number_format($estado->ingresos,2) }}

            </td>

            <td>

                $ {{ number_format($estado->costos,2) }}

            </td>

            <td>

                $ {{ number_format($estado->noi,2) }}

            </td>

            <td>

                $ {{ number_format($estado->ebit,2) }}

            </td>

            <td>

                $ {{ number_format($estado->ebt,2) }}

            </td>

            <td>

                $ {{ number_format($estado->impuestos,2) }}

            </td>

            <td>

                <strong>

                    $ {{ number_format($estado->utilidad_neta,2) }}

                </strong>

            </td>

            <td>

                <a href="/inversiones/{{ $inversion->id }}/estado-resultados/{{ $estado->id }}/edit"
                   class="btn-secondary">

                    Ver

                </a>

                <form method="POST"
                      action="/inversiones/{{ $inversion->id }}/estado-resultados/{{ $estado->id }}"
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

<!-- MODAL GENERAR -->

<div id="modalGenerar"
     style="
        display:none;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:rgba(0,0,0,.5);
        z-index:9999;
     ">

    <div style="
        background:white;
        width:500px;
        max-width:90%;
        margin:100px auto;
        padding:20px;
        border-radius:10px;
    ">

        <h3>
            📊 Generar Estado de Resultados
        </h3>

        <form method="POST"
              action="/inversiones/{{ $inversion->id }}/estado-resultados/generar">

            @csrf

            <div class="form-group">

                <label>Año</label>

                <input type="number"
                       name="anio"
                       class="form-control"
                       value="{{ date('Y') }}"
                       required>

            </div>

            <div class="form-group">

                <label>Otros Gastos</label>

                <input type="number"
                    step="0.01"
                    name="otros_gastos"
                    class="form-control"
                    value="{{ $inversion->otros_gastos ?? 0 }}">

            </div>

            <div class="form-group">

                <label>Gasto Financiero</label>

                <input type="number"
       step="0.01"
       name="gasto_financiero"
       class="form-control"
       value="{{ $inversion->gasto_financiero ?? 0 }}">

            </div>

            <div style="
                display:flex;
                justify-content:flex-end;
                gap:10px;
                margin-top:20px;
            ">

                <button type="button"
                        class="btn-secondary"
                        onclick="cerrarModalGenerar()">

                    Cancelar

                </button>

                <button type="submit"
                        class="btn-primary-custom">

                    ⚙️ Generar

                </button>

            </div>

        </form>

    </div>

</div>

<script>

function abrirModalGenerar()
{
    document.getElementById(
        'modalGenerar'
    ).style.display = 'block';
}

function cerrarModalGenerar()
{
    document.getElementById(
        'modalGenerar'
    ).style.display = 'none';
}

</script>

@endsection