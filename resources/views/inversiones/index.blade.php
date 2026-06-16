@extends('layouts.app')

@section('content')





<div class="page-container">
<h1 class="page-title">
    Inversiones
</h1>

@if(auth()->user()->role == 'admin')

    <a href="/inversiones/create"
       class="btn-new">

        + Nueva Inversión

    </a>

@endif

</div>

<p style="color:green;">
    {{ session('success') }}
</p>

<hr>
<div style="overflow-x:auto;">
<table class="table-dashboard">
<thead>

    <tr>

        <th>Inversión</th>

        <th>Ubicación</th>

        <th>Personas</th>

        <th>Entidades</th>

        @if(auth()->user()->role == 'admin')
            <th>Valor</th>
        @endif

        @if(auth()->user()->role == 'admin')
            <th>NOI</th>
        @endif

        @if(auth()->user()->role == 'admin')
            <th>Cap Rate</th>
        @endif

        <th>Módulos</th>

        <th>Acciones</th>

    </tr>

</thead>

<tbody>

@foreach($inversiones as $inv)

    @php

        $valor =
            $inv->ultimoAvaluo?->valor_total ?? 0;

        $ingresos =
            $inv->comercial->sum('subtotal');

        $costos =
            $inv->costo_operativo_anual ?? 0;

        $noi =
            $ingresos - $costos;

        $capRate =
            $valor > 0
            ? ($noi / $valor) * 100
            : 0;

    @endphp

    <tr>

        <td>

            <strong>
                {{ $inv->nombre }}
            </strong>

            <br>

            <small style="color:#6b7280;">
                {{ $inv->clave }}
            </small>

        </td>

        <td>

            {{ $inv->ubicacion }}

        </td>

        <td>

            👥 {{ $inv->clientes->count() }}

        </td>

        <td>

            🏢 {{ $inv->entidades->count() }}

        </td>

        @if(auth()->user()->role == 'admin')

            <td>

                $ {{ number_format($valor,0) }}

            </td>

            <td>

                $ {{ number_format($noi,0) }}

            </td>

            <td>

                <span style="
                    font-weight:bold;
                    color:
                    {{ $capRate >= 10
                        ? '#16a34a'
                        : ($capRate >= 5
                            ? '#ca8a04'
                            : '#dc2626') }};
                ">
                    {{ number_format($capRate,2) }}%
                </span>

            </td>

        @endif

        <td>

            @if(auth()->user()->tienePermiso($inv->id,'avaluos'))
                📊
            @endif

            @if(auth()->user()->tienePermiso($inv->id,'activos'))
                🏢
            @endif

            @if(auth()->user()->tienePermiso($inv->id,'servicios'))
                ⚙️
            @endif

            @if(auth()->user()->tienePermiso($inv->id,'comercial'))
                💰
            @endif

            @if(auth()->user()->tienePermiso($inv->id,'entidades'))
                🏛️
            @endif

            @if(auth()->user()->tienePermiso($inv->id,'activos_registrales'))
                📑
            @endif

            @if(auth()->user()->tienePermiso($inv->id,'estado_resultados'))
                📈
            @endif

        </td>

        <td>

        <a href="/inversiones/{{ $inv->id }}"
   class="btn-secondary">

    📂 Abrir

</a>
        </td>

    </tr>

@endforeach

</tbody>

</table>

</div>

@endsection