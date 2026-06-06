@extends('layouts.app')




@section('content')


<style>
.table-dashboard tbody tr:hover{
    background:#eff6ff;
    transition:.2s;
}

.table-dashboard td{
    white-space:nowrap;
}

.table-dashboard tfoot tr{
    background:#f3f4f6;
    font-size:15px;
}

.table-dashboard tbody tr:nth-child(even){
    background:#fafafa;
}
.section-title-dashboard{
    font-size:24px;
    font-weight:700;
    margin-bottom:20px;
}

.table-container{
    overflow-x:auto;
    margin-top:20px;
}

.table-dashboard{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
}

.table-dashboard thead tr:first-child th{
    background:#111827;
    color:white;
    font-size:15px;
    padding:14px;
}

.table-dashboard thead tr:nth-child(2) th{
    background:#374151;
    color:white;
    padding:12px;
}

.table-dashboard th{
    text-align:center;
}

.table-dashboard td{
    padding:12px;
    border-bottom:1px solid #e5e7eb;
    text-align:right;
}

.table-dashboard td:first-child{
    text-align:left;
    font-weight:600;
}

.table-dashboard tbody tr:hover{
    background:#f9fafb;
}

.table-dashboard tfoot td{
    background:#f3f4f6;
    font-weight:bold;
}

.table-dashboard thead tr:first-child th{
    background:#0f172a;
    color:#fff;
    text-align:center;
    font-size:16px;
    border-right:2px solid #475569;
}

.table-dashboard thead tr:nth-child(2) th{
    background:#334155;
    color:white;
    text-align:center;
}

.table-dashboard th,
.table-dashboard td{
    border:1px solid #e5e7eb;
}

</style>
<div class="page-container">

    <h1 class="page-title">
        📊 Dashboard
    </h1>

</div>

<div class="dashboard-grid">

    <!-- CLIENTES -->
    <a href="/clientes" class="dashboard-card">

        <div class="dashboard-icon">
            👥
        </div>

        <div class="dashboard-title">
            Clientes
        </div>

        <div class="dashboard-description">
            Gestionar base de clientes
        </div>

        <div class="dashboard-metric">

            Total registrados:
            <strong>

                {{ $clientes }}

            </strong>

        </div>

    </a>

    <!-- INVERSIONES -->
    <a href="/inversiones" class="dashboard-card">

        <div class="dashboard-icon">
            💼
        </div>

        <div class="dashboard-title">
            Inversiones
        </div>

        <div class="dashboard-description">
            Gestionar portafolio de inversión
        </div>

        <div class="dashboard-metric">

            💰 Financiero:
            <strong>

                $ {{ number_format($totalFinanciero, 2) }}

            </strong>

        </div>

        <div class="dashboard-metric">

            ⚙️ Operativo:
            <strong>

                $ {{ number_format($totalOperativo, 2) }}

            </strong>

        </div>

        <div class="dashboard-metric">

            📈 Comercial:
            <strong>

                $ {{ number_format($totalComercial, 2) }}

            </strong>

        </div>

    </a>

    <!-- ENTIDADES -->
    <a href="/entidades" class="dashboard-card">

        <div class="dashboard-icon">
            🏢
        </div>

        <div class="dashboard-title">
            Entidades
        </div>

        <div class="dashboard-description">
            Gestionar entidades relacionadas
        </div>

        <div class="dashboard-metric">

            Total entidades:
            <strong>

                {{ $entidades }}

            </strong>

        </div>

    </a>


    

</div>
</div> {{-- FIN dashboard-grid --}}

<hr style="margin:40px 0;">

<h2 class="section-title-dashboard">
     Calidad de Inversión
</h2>

<div class="table-container">

    <table class="table-dashboard">

  <thead>

<tr>

    <th rowspan="2">

        Ticker

    </th>

    <th colspan="5">

        Calidad de Inversión

    </th>

    <th colspan="4">

        Retorno del Activo

    </th>

</tr>

<tr>

    <th>Inversión ($)</th>

    <th>%</th>

    <th>Ingresos ($)</th>

    <th>%</th>

    <th>Rend (%)</th>
    <th>Costos ($)</th>

    <th>%</th>

    <th>NOI ($)</th>

    <th>Cap Rate (%)</th>

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

                    $participacion =
                        $totalValorInversion > 0
                        ? ($valor / $totalValorInversion) * 100
                        : 0;

                    $participacionIngresos =
                        $totalIngresos > 0
                        ? ($ingresos / $totalIngresos) * 100
                        : 0;

                    $participacionCostos =
                        $totalCostos > 0
                        ? ($costos / $totalCostos) * 100
                        : 0;

                    $rendimiento =
                        $valor > 0
                        ? ($ingresos / $valor) * 100
                        : 0;

                    $capRate =
                        $valor > 0
                        ? ($noi / $valor) * 100
                        : 0;

                @endphp

                <tr>

                    <td>
                        {{ $inv->nombre }}
                    </td>

                    <td>
                        {{ number_format($valor, 2) }}
                    </td>

                    <td>
                        {{ number_format($participacion, 2) }}%
                    </td>

                    <td>
                        {{ number_format($ingresos, 2) }}
                    </td>

                    <td>
                        {{ number_format($participacionIngresos, 2) }}%
                    </td>

                    <td>
                        {{ number_format($rendimiento, 2) }}%
                    </td> 
                    
                    <td>
                        {{ number_format($costos, 2) }}
                    </td>

                    <td>
                        {{ number_format($participacionCostos, 2) }}%
                    </td>

                    <td style="
                        font-weight:bold;
                        color:#2563eb;
                    ">
                        {{ number_format($noi, 2) }}
                    </td>

              

                    <td style="
                        font-weight:bold;
                        color:
                        {{ $capRate >= 10
                            ? '#16a34a'
                            : ($capRate >= 5
                                ? '#ca8a04'
                                : '#dc2626') }};
                    ">
                        {{ number_format($capRate, 2) }}%
                    </td>

                </tr>

            @endforeach

        </tbody>

        <tfoot>

            <tr>

                <td>
                    TOTAL
                </td>

                <td>
                    {{ number_format($totalValorInversion, 2) }}
                </td>

                <td>
                    100%
                </td>

                <td>
                    {{ number_format($totalIngresos, 2) }}
                </td>

                <td>
                    100%
                </td>

                <td>
                    -
                </td>

                <td>
                    {{ number_format($totalCostos, 2) }}
                </td>

                <td>
                    100%
                </td>
                <td style="
                    font-weight:bold;
                    color:#2563eb;
                ">
                    {{ number_format($totalIngresos - $totalCostos, 2) }}
                </td>


                <td>
                    -
                </td>

            </tr>

        </tfoot>

    </table>


    </div> {{-- FIN TABLA CALIDAD DE INVERSION --}}

<hr style="margin:40px 0;">

<h2 class="section-title-dashboard">
 Eficiencia del Capital e Impacto Fiscal
</h2>

<div class="table-container">

    <table class="table-dashboard">

        <thead>

            <tr>

                <th rowspan="2">
                    Ticker
                </th>

                <th colspan="4"
                    style="background:#1e3a8a;color:white;">
                    Eficiencia del Capital
                </th>

                <th colspan="4"
                    style="background:#7c3aed;color:white;">
                    Estrategia Financiera
                </th>

                <th colspan="6"
                    style="background:#065f46;color:white;">
                    Impacto Fiscal
                </th>

            </tr>

            <tr>

                <th>Deprec. ($)</th>
                <th>Deprec. (%)</th>

                <th>EBIT ($)</th>
                <th>EBIT (%)</th>

                <th>Intereses ($)</th>
                <th>Intereses (%)</th>

                <th>EBT ($)</th>
                <th>EBT (%)</th>

                <th>Imp. HN ($)</th>
                <th>Imp. HN (%)</th>

                <th>G/P ($)</th>
                <th>G/P (%)</th>

                <th>Imp. US ($)</th>

                <th>NET ($)</th>

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

                    $depreciacion =
                        $inv->ultimoAvaluo?->depreciacion ?? 0;

                    $noi =
                        $ingresos - $costos;

                    $ebit =
                        $noi - $depreciacion;

                    $intereses = 0;

                    $ebt =
                        $ebit - $intereses;

                    $impuestoHN =
                        $ebt *
                        (($inv->tasa_impuestos ?? 0) / 100);

                    $gp =
                        $ebt - $impuestoHN;

                    $impuestoUS = 0;

                    $net =
                        $gp - $impuestoUS;

                @endphp

                <tr>

                    <td>
                        {{ $inv->nombre }}
                    </td>

                    <td>
                        {{ number_format($depreciacion,2) }}
                    </td>

                    <td>
                        {{ $valor > 0
                            ? number_format(($depreciacion/$valor)*100,2)
                            : 0 }}%
                    </td>

                    <td>
                        {{ number_format($ebit,2) }}
                    </td>

                    <td>
                        {{ $ingresos > 0
                            ? number_format(($ebit/$ingresos)*100,2)
                            : 0 }}%
                    </td>

                    <td>
                        {{ number_format($intereses,2) }}
                    </td>

                    <td>
                        0%
                    </td>

                    <td>
                        {{ number_format($ebt,2) }}
                    </td>

                    <td>
                        {{ $ingresos > 0
                            ? number_format(($ebt/$ingresos)*100,2)
                            : 0 }}%
                    </td>

                    <td>
                        {{ number_format($impuestoHN,2) }}
                    </td>

                    <td>
                        {{ $ebt > 0
                            ? number_format(($impuestoHN/$ebt)*100,2)
                            : 0 }}%
                    </td>

                    <td>
                        {{ number_format($gp,2) }}
                    </td>

                    <td>
                        {{ $ebt > 0
                            ? number_format(($gp/$ebt)*100,2)
                            : 0 }}%
                    </td>

                    <td>
                        {{ number_format($impuestoUS,2) }}
                    </td>

                    <td style="
                        font-weight:bold;
                        color:#16a34a;
                    ">
                        {{ number_format($net,2) }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</div>

</div>


@endsection