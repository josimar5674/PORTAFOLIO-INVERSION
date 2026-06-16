@extends('layouts.app')

@section('content')

@php

$totalMensual =
    $servicios->sum('costo_mensual');

$totalAnual =
    $servicios->sum('costo_anual');

$totalServicios =
    $servicios->count();

$categorias =
    $servicios->pluck('categoria')
              ->filter()
              ->unique()
              ->count();

@endphp

<div class="investment-header">

    <div>

        <h1>
            ⚙️ Servicios
        </h1>

        <small>

            {{ $inversion->nombre }}

            ·

            {{ $totalServicios }} registros

        </small>

    </div>

    <div>

        <a href="/inversiones/{{ $inversion->id }}"
           class="btn-secondary">

            ← Volver

        </a>

        <a href="/inversiones/{{ $inversion->id }}/servicios/create"
           class="btn-primary-custom">

            + Nuevo Servicio

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

        ⚙️ Servicios

        <strong>

            {{ $totalServicios }}

        </strong>

    </div>

    <div class="summary-card">

        📂 Categorías

        <strong>

            {{ $categorias }}

        </strong>

    </div>

    <div class="summary-card">

        💰 Total Mensual

        <strong>

            $ {{ number_format($totalMensual, 2) }}

        </strong>

    </div>

    <div class="summary-card">

        📆 Total Anual

        <strong>

            $ {{ number_format($totalAnual, 2) }}

        </strong>

    </div>

</div>

<div style="overflow-x:auto; margin-top:25px;">

<table class="table-dashboard">

    <thead>

        <tr>

            <th>Clave</th>

            <th>Servicio</th>

            <th>Prestador</th>

            <th>Categoría</th>

            <th>Relación</th>

            <th>Mensual</th>

            <th>Anual</th>

            <th>Acciones</th>

        </tr>

    </thead>

    <tbody>

    @foreach($servicios as $servicio)

        <tr>

            <td>

                {{ $servicio->clave }}

            </td>

            <td>

                <strong>

                    {{ $servicio->servicio }}

                </strong>

            </td>

            <td>

                {{ $servicio->prestador }}

            </td>

            <td>

                {{ $servicio->categoria }}

            </td>

            <td>

                {{ $servicio->relacion }}

            </td>

            <td>

                $ {{ number_format($servicio->costo_mensual,2) }}

            </td>

            <td>

                $ {{ number_format($servicio->costo_anual,2) }}

            </td>

            <td>

                <a href="/inversiones/{{ $inversion->id }}/servicios/{{ $servicio->id }}/edit"
                   class="btn-secondary">

                    Ver

                </a>

                <form method="POST"
                      action="/inversiones/{{ $inversion->id }}/servicios/{{ $servicio->id }}"
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

@endsection