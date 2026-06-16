@extends('layouts.app')

@section('content')

@php

$totalActivos = $assets->count();

$totalNiveles =
$assets->max('level_number') ?? 0;

$tipos =
$assets->pluck('type')
->unique()
->count();

@endphp

<div class="investment-header">

    <div>

        <h1>
            🏢 Activos
        </h1>

        <small>
            {{ $inversion->nombre }} .
            {{ $totalActivos }} registros

        </small>

    </div>

    <div>

        <a href="/inversiones/{{ $inversion->id }}"
            class="btn-secondary">
            ← Volver
        </a>

        <a href="/inversiones/{{ $inversion->id }}/assets/create"
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

        🏢 Total Activos

        <strong>
            {{ $totalActivos }}
        </strong>

    </div>

    <div class="summary-card">

        📦 Tipos

        <strong>
            {{ $tipos }}
        </strong>

    </div>

    <div class="summary-card">

        🏗️ Niveles

        <strong>
            {{ $totalNiveles }}
        </strong>

    </div>

</div>


<div style="overflow-x:auto; margin-top:25px;">

    <table class="table-dashboard">

        <thead>

            <tr>

                <th>Nombre</th>

                <th>Tipo</th>

                <th>Nivel</th>

                <th>Acciones</th>

            </tr>

        </thead>

        <tbody>

            @foreach($assets as $asset)

            <tr>

                <td>

                    <strong>
                        {{ $asset->name }}
                    </strong>

                </td>

                <td>

                    {{ $asset->type }}

                </td>

                <td>

                    {{ $asset->level_number }}

                </td>
                <td>

                    <a href="/inversiones/{{ $inversion->id }}/assets/{{ $asset->id }}/edit"
                        class="btn-secondary">

                        Ver

                    </a>

                    <form action="/inversiones/{{ $inversion->id }}/assets/{{ $asset->id }}"
                        method="POST"
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