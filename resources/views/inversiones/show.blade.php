@extends('layouts.app')

@section('content')

<style>

.investment-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    padding:20px;
    background:#fff;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.investment-header h1{
    margin:0;
    font-size:28px;
    color:#111827;
}

.investment-header small{
    color:#6b7280;
    font-size:14px;
}

.summary-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
    margin-bottom:35px;
}

.summary-card{
    background:white;
    border-radius:12px;
    padding:20px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
    display:flex;
    flex-direction:column;
    gap:8px;
    font-size:14px;
    color:#6b7280;
}

.summary-card strong{
    font-size:22px;
    color:#111827;
}

.module-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
    gap:20px;
}

.module-card{
    text-decoration:none;
    background:white;
    border-radius:14px;
    padding:25px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
    transition:.25s;
    color:#111827;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:10px;
    min-height:140px;
}

.module-card:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 25px rgba(0,0,0,.12);
}

.module-card .icon{
    font-size:40px;
}

.module-card .title{
    font-size:16px;
    font-weight:600;
}

.module-card .action{
    font-size:13px;
    color:#2563eb;
}

.info-section{
    margin-top:40px;
    background:white;
    border-radius:12px;
    padding:25px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.info-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

.info-item{
    padding:12px;
    border-bottom:1px solid #e5e7eb;
}

.info-label{
    font-size:13px;
    color:#6b7280;
    margin-bottom:5px;
}

.info-value{
    font-weight:600;
    color:#111827;
}

.metric-good{
    color:#16a34a;
}

.metric-warning{
    color:#ca8a04;
}

.metric-danger{
    color:#dc2626;
}

@media(max-width:768px){

    .investment-header{
        flex-direction:column;
        align-items:flex-start;
        gap:15px;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

}

</style>


<div class="investment-header">

    <div>

        <h1>
            {{ $inversion->nombre }}
        </h1>

        <small>
            {{ $inversion->clave }}
        </small>

    </div>

    <div>

        <a href="/inversiones"
           class="btn-secondary">

            ← Volver

        </a>

        @if(auth()->user()->role == 'admin')

        <a href="/inversiones/{{ $inversion->id }}/edit"
           class="btn-primary-custom">

            ✏️ Editar

        </a>

        @endif

    </div>

</div>

<div class="summary-grid">

    <div class="summary-card">

        📍 Ubicación

        <strong>
            {{ $inversion->ubicacion ?? 'N/A' }}
        </strong>

    </div>

    <div class="summary-card">

        👥 Personas

        <strong>
            {{ $inversion->clientes->count() }}
        </strong>

    </div>

    @if(auth()->user()->tienePermiso($inversion->id,'entidades'))

    <div class="summary-card">

        🏢 Entidades

        <strong>
            {{ $inversion->entidades->count() }}
        </strong>

    </div>

    @endif

    @if(auth()->user()->tienePermiso($inversion->id,'avaluos'))

    <div class="summary-card">

        💰 Valor Avalúo

        <strong>
            $
            {{ number_format($inversion->ultimoAvaluo?->valor_total ?? 0,0) }}
        </strong>

    </div>

    @endif

    @if(auth()->user()->tienePermiso($inversion->id,'estado_resultados'))

    <div class="summary-card">

        📈 Utilidad Neta

        <strong>
            L
            {{ number_format($inversion->ultimoEstadoResultado?->utilidad_neta ?? 0,0) }}
        </strong>

    </div>

    @endif

    @if(auth()->user()->tienePermiso($inversion->id,'servicios'))

    <div class="summary-card">

        ⚙️ Costo Operativo

        <strong>
            $
            {{ number_format($inversion->costo_operativo_anual ?? 0,0) }}
        </strong>

    </div>

    @endif


@if(auth()->user()->tienePermiso($inversion->id,'comercial'))

<div class="summary-card">

    💰 Comercial

    <strong>
        $ {{ number_format($inversion->comercial->sum('subtotal'),0) }}
    </strong>

    <small>
        {{ $inversion->comercial->count() }} registros
    </small>

</div>

@endif

    @if(auth()->user()->tienePermiso($inversion->id,'activos_registrales'))

    <div class="summary-card">

        📑 Activos Registrales

        <strong>
            {{ $inversion->activosRegistrales->count() }}
        </strong>

    </div>

    @endif

    @if(auth()->user()->role == 'admin')

    <div class="summary-card">

        📊 Tasa Desc.

        <strong>
            {{ $inversion->tasa_descuento }}%
        </strong>

    </div>

    <div class="summary-card">

        🧾 Tasa Imp.

        <strong>
            {{ $inversion->tasa_impuestos }}%
        </strong>

    </div>

    <div class="summary-card">

        🚀 Crecimiento

        <strong>
            {{ $inversion->tasa_crecimiento }}%
        </strong>

    </div>

    @endif

</div>

<hr style="margin:30px 0;">
<h2 style="
    margin-bottom:20px;
    color:#111827;
">
    🚀 Módulos Disponibles
</h2>

<div class="module-grid">

@if(auth()->user()->tienePermiso($inversion->id,'avaluos'))

<a href="/inversiones/{{ $inversion->id }}/avaluos"
   class="module-card">

    <div class="icon">
        📊
    </div>

    <div class="title">
        Avalúos
    </div>

  

</a>

@endif

@if(auth()->user()->tienePermiso($inversion->id,'activos'))

<a href="/inversiones/{{ $inversion->id }}/assets"
   class="module-card">

    <div class="icon">
        🏢
    </div>

    <div class="title">
        Activos
    </div>

</a>

@endif

@if(auth()->user()->tienePermiso($inversion->id,'servicios'))

<a href="/inversiones/{{ $inversion->id }}/servicios"
   class="module-card">

    <div class="icon">
        ⚙️
    </div>

   <div class="title">
        Servicios
    </div>

</a>

@endif


@if(auth()->user()->tienePermiso($inversion->id,'comercial'))

<a href="/inversiones/{{ $inversion->id }}/comercial"
   class="module-card">

    <div class="icon">
        💰
    </div>

    <div class="title">
        Comercial
    </div>
    
</a>

@endif

@if(auth()->user()->tienePermiso($inversion->id,'entidades'))

<a href="/inversiones/{{ $inversion->id }}/entidades"
   class="module-card">

    <div class="icon">
        🏛️
    </div>

    <div class="title">
        Entidades
    </div>

</a>

@endif

@if(auth()->user()->tienePermiso($inversion->id,'activos_registrales'))

<a href="/inversiones/{{ $inversion->id }}/activos-registrales"
   class="module-card">

    <div class="icon">
        📑
    </div>

    <div class="title">
        Activos Registrales
    </div>

</a>

@endif


@if(auth()->user()->tienePermiso($inversion->id,'estado_resultados'))

<a href="/inversiones/{{ $inversion->id }}/estado-resultados"
   class="module-card">

    <div class="icon">
        📈
    </div>

    <div class="title">
        Estado de Resultados
    </div>
</a>

@endif

</div>

@endsection


