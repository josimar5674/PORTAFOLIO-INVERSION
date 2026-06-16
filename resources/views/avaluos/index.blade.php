@extends('layouts.app')

@section('content')

@php

    $ultimoAvaluo = $avaluos->first();

    $totalValor = $avaluos->sum('valor_total');

    $promedioValor =
        $avaluos->count() > 0
        ? $totalValor / $avaluos->count()
        : 0;

    $valorMaximo =
        $avaluos->max('valor_total');

@endphp

<div class="investment-header">

    <div>

        <h1>
            📊 Avalúos
        </h1>

        <small>
            {{ $avaluos->count() }} registros
        </small>

    </div>

    <div>

   <a href="/inversiones/{{ $inversion_id }}"
   class="btn-secondary">

    ← Volver

</a>

        <a href="/inversiones/{{ $inversion_id }}/avaluos/create"
           class="btn-primary-custom">

            + Nuevo Avalúo

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

        📊 Total Avalúos

        <strong>

            {{ $avaluos->count() }}

        </strong>

    </div>

    <div class="summary-card">

        📅 Último Avalúo

        <strong>

            {{ $ultimoAvaluo?->fecha_avaluo ?? 'N/A' }}

        </strong>

    </div>

    <div class="summary-card">

        💰 Valor Actual

        <strong>

            $
            {{ number_format($ultimoAvaluo?->valor_total ?? 0,0) }}

        </strong>

    </div>

    <div class="summary-card">

        📈 Valor Promedio

        <strong>

            $
            {{ number_format($promedioValor,0) }}

        </strong>

    </div>

    <div class="summary-card">

        🏆 Valor Máximo

        <strong>

            $
            {{ number_format($valorMaximo,0) }}

        </strong>

    </div>

</div>


<div style="overflow-x:auto; margin-top:25px;">

    <table class="table-dashboard">

        <thead>

            <tr>

                <th>Fecha</th>

                <th>Terreno</th>

                <th>Construcción</th>

                <th>Depreciación</th>

                <th>Valor Total</th>

                <th>Observaciones</th>

                <th>Acciones</th>

            </tr>

        </thead>

        <tbody>

            @foreach($avaluos as $avaluo)

            <tr>

                <td>

                    {{ \Carbon\Carbon::parse($avaluo->fecha_avaluo)->format('d/m/Y') }}

                </td>

                <td>

                    $ {{ number_format($avaluo->subtotal_terreno,2) }}

                </td>

                <td>

                    $ {{ number_format($avaluo->subtotal_construccion,2) }}

                </td>

                <td>

                    $ {{ number_format($avaluo->depreciacion,2) }}

                </td>

                <td style="
                    font-weight:bold;
                    color:#16a34a;
                ">

                    $ {{ number_format($avaluo->valor_total,2) }}

                </td>

                <td>

                    {{ \Illuminate\Support\Str::limit($avaluo->observaciones,50) }}

                </td>

                <td>

                    <a href="/inversiones/{{ $inversion_id }}/avaluos/{{ $avaluo->id }}/edit"
                       class="btn-secondary">

                        Ver

                    </a>

                    <form action="/inversiones/{{ $inversion_id }}/avaluos/{{ $avaluo->id }}"
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