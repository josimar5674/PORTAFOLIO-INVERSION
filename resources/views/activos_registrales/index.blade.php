@extends('layouts.app')

@section('content')

@php

$totalActivos = $activos->count();

$totalValor =
    $activos->sum('valor_escrituracion');

$totalInscripciones =
    $activos->sum(function($a){
        return $a->inscripciones->count();
    });

@endphp

<div class="investment-header">

    <div>

        <h1>
            📑 Activos Inmoviliarios
        </h1>

        <small>

            {{ $inversion->nombre }}

            ·

            {{ $totalActivos }} registros

        </small>

    </div>

    <div>

        <a href="/inversiones/{{ $inversion->id }}"
           class="btn-secondary">

            ← Volver

        </a>

        <a href="/inversiones/{{ $inversion->id }}/activos-registrales/create"
           class="btn-primary-custom">

            + Nuevo Activo

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

        📑 Activos

        <strong>

            {{ $totalActivos }}

        </strong>

    </div>

    <div class="summary-card">

        💰 Valor Total

        <strong>

            $ {{ number_format($totalValor,2) }}

        </strong>

    </div>

    <div class="summary-card">

        📋 Inscripciones

        <strong>

            {{ $totalInscripciones }}

        </strong>

    </div>

</div>

<div style="overflow-x:auto; margin-top:25px;">

<table class="table-dashboard">

    <thead>

        <tr>

            <th>Matrícula</th>

            <th>Ubicación</th>

            <th>Ciudad</th>

            <th>Zonificación</th>

            <th>Valor</th>

            <th>Inscripciones</th>

            <th>Acciones</th>

        </tr>

    </thead>

    <tbody>

    @foreach($activos as $activo)

        <tr>

            <td>

                <strong>

                    {{ $activo->numero_matricula }}

                </strong>

            </td>

            <td>

                {{ $activo->ubicacion_inmueble }}

            </td>

            <td>

                {{ $activo->ciudad }}

            </td>

            <td>

                {{ $activo->zonificacion }}

            </td>

            <td>

                $ {{ number_format($activo->valor_escrituracion,2) }}

            </td>

            <td>

                {{ $activo->inscripciones->count() }}

            </td>

            <td>

                <a href="/activos-registrales/{{ $activo->id }}/edit"
                   class="btn-secondary">

                    Ver

                </a>

                <form method="POST"
                      action="/activos-registrales/{{ $activo->id }}"
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