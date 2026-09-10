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
@php

    $totalValor = 0;
    $totalNOI = 0;
    $totalCostoOperativo = 0;
    $totalComercial = 0;

    $cantidadInversiones = $inversiones->count();

    foreach ($inversiones as $inv) {

        /*
        |--------------------------------------------------------------------------
        | VALOR AVALÚO
        |--------------------------------------------------------------------------
        */

        if (
            auth()->user()->role === 'admin' ||
            auth()->user()->tienePermiso($inv->id, 'avaluos')
        ) {

            $totalValor +=
                $inv->ultimoAvaluo?->valor_total ?? 0;

        }


        /*
        |--------------------------------------------------------------------------
        | COMERCIAL
        |--------------------------------------------------------------------------
        */

        if (
            auth()->user()->role === 'admin' ||
            auth()->user()->tienePermiso($inv->id, 'comercial')
        ) {

            $totalComercial +=
                $inv->comercial->sum('subtotal');

        }


        /*
        |--------------------------------------------------------------------------
        | COSTO OPERATIVO
        |--------------------------------------------------------------------------
        */

        if (
            auth()->user()->role === 'admin' ||
            auth()->user()->tienePermiso($inv->id, 'servicios')
        ) {

            $totalCostoOperativo +=
                $inv->costo_operativo_anual ?? 0;

        }


        /*
        |--------------------------------------------------------------------------
        | NOI
        |--------------------------------------------------------------------------
        */

        if (
            auth()->user()->role === 'admin' ||
            (
                auth()->user()->tienePermiso($inv->id, 'avaluos') &&
                auth()->user()->tienePermiso($inv->id, 'comercial') &&
                auth()->user()->tienePermiso($inv->id, 'servicios')
            )
        ) {

            $ingresos =
                $inv->comercial->sum('subtotal');

            $costos =
                $inv->costo_operativo_anual ?? 0;

            $totalNOI +=
                $ingresos - $costos;

        }

    }

@endphp


<div class="summary-grid">

    <!-- ================================================= -->
    <!-- TOTAL INVERSIONES -->
    <!-- ================================================= -->

    <div class="summary-card">

        🏢 Inversiones

        <strong>
            {{ $cantidadInversiones }}
        </strong>

    </div>


    <!-- ================================================= -->
    <!-- VALOR TOTAL -->
    <!-- ================================================= -->

    @if(auth()->user()->role === 'admin' || $totalValor > 0)

        <div class="summary-card">

            💰 Valor Avalúos

            <strong>
                $
                {{ number_format($totalValor, 0) }}
            </strong>

        </div>

    @endif


    <!-- ================================================= -->
    <!-- NOI -->
    <!-- ================================================= -->

    @if(auth()->user()->role === 'admin' || $totalNOI != 0)

        <div class="summary-card">

            📈 NOI Total

            <strong>
                $
                {{ number_format($totalNOI, 0) }}
            </strong>

        </div>

    @endif


    <!-- ================================================= -->
    <!-- COSTO OPERATIVO -->
    <!-- ================================================= -->

    @if(auth()->user()->role === 'admin' || $totalCostoOperativo > 0)

        <div class="summary-card">

            ⚙️ Costo Operativo

            <strong>
                $
                {{ number_format($totalCostoOperativo, 0) }}
            </strong>

        </div>

    @endif


    <!-- ================================================= -->
    <!-- COMERCIAL -->
    <!-- ================================================= -->

    @if(auth()->user()->role === 'admin' || $totalComercial > 0)

        <div class="summary-card">

            💵 Comercial

            <strong>
                $
                {{ number_format($totalComercial, 0) }}
            </strong>

        </div>

    @endif

</div>



<hr>
<div style="overflow-x:auto;">
<table class="table-dashboard">
<thead>

    <tr>

        <th>Inversión</th>
  

      
        @if(auth()->user()->role == 'admin')
            <th>Valor</th>
        @endif

        @if(auth()->user()->role == 'admin')
            <th>NOI</th>
        @endif

        @if(auth()->user()->role == 'admin')
            <th>Cap Rate</th>
        @endif

            @if(auth()->user()->role == 'user')

        <th>Módulos</th>
        @endif

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

<tr onclick="window.location='{{ url('/inversiones/' . $inv->id) }}'">


        <td>

            <strong>
                {{ $inv->nombre }}
            </strong>

            <br>

            <small style="color:#6b7280;">
                {{ $inv->clave }}
            </small>

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
                            : '#dc2626') }};">



                    {{ number_format($capRate,2) }}%
                </span>

            </td>

        @endif

                @if(auth()->user()->role == 'user')

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
         @endif

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