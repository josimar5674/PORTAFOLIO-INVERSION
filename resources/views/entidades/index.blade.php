@extends('layouts.app')

@section('content')

@php

$totalEntidades =
    $entidades->count();

$totalCapital =
    $entidades->sum('capital_social_max');

$totalTipos =
    $entidades->pluck('tipo_societario')
              ->filter()
              ->unique()
              ->count();

@endphp

<div class="investment-header">

    <div>

        <h1>
            🏢 Entidades
        </h1>

        <small>

@if(!empty($inversion))
                {{ $inversion->nombre }}

                ·

            @endif

            {{ $totalEntidades }} registros

        </small>

    </div>

    <div>

@if(!empty($inversion))
       

        <a href="/inversiones/{{ $inversion->id }}"
           class="btn-secondary">

            ← Volver

        </a>

        @else

            <a href="/"
               class="btn-secondary">

                ← Dashboard

            </a>

        @endif

     @if(auth()->user()->role == 'admin')

<a href="/entidades/create"
   class="btn-primary-custom">

    + Nueva Entidad

</a>

@endif
    </div>

</div>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="summary-grid">

    <div class="summary-card">

        🏢 Entidades

        <strong>

            {{ $totalEntidades }}

        </strong>

    </div>

    <div class="summary-card">

        🏛️ Tipos Societarios

        <strong>

            {{ $totalTipos }}

        </strong>

    </div>

    <div class="summary-card">

        💰 Capital Social

        <strong>

            $ {{ number_format($totalCapital,2) }}

        </strong>

    </div>

</div>

<div style="overflow-x:auto; margin-top:25px;">

<table class="table-dashboard">

    <thead>

        <tr>

            <th>Entidad</th>

            <th>RTN</th>

            <th>Tipo</th>

            <th>Gerente</th>

            <th>Constitución</th>

            <th>Capital</th>

            <th>Inversiones</th>

            <th>Acciones</th>

        </tr>

    </thead>

    <tbody>

    @foreach($entidades as $entidad)

        <tr>

            <td>

                <strong>

                    {{ $entidad->denominacion_social }}

                </strong>

            </td>

            <td>

                {{ $entidad->identificador_tributario }}

            </td>

            <td>

                {{ $entidad->tipo_societario }}

            </td>

            <td>

                {{ $entidad->gerente_general }}

            </td>

            <td>

                {{ $entidad->fecha_constitucion }}

            </td>

            <td>

                $ {{ number_format($entidad->capital_social_max ?? 0,2) }}

            </td>

            <td>

                {{ $entidad->inversiones->count() }}

            </td>

            <td>

             @if(
    auth()->user()->role == 'admin'
    ||
    auth()->user()->tienePermiso($inversion->id, 'entidades')
)

@if(isset($inversion))

<a href="/entidades/{{ $entidad->id }}/edit?inversion_id={{ $inversion->id }}"
   class="btn-secondary">

    Ver

</a>

@else

<a href="/entidades/{{ $entidad->id }}/edit"
   class="btn-secondary">

    Ver

</a>

@endif

@endif

                <form method="POST"
                      action="/entidades/{{ $entidad->id }}"
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