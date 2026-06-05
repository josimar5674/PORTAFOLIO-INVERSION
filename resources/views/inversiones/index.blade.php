@extends('layouts.app')

@section('content')



<div class="page-container">

    <h1 class="page-title">Inversiones</h1>

    <a href="/inversiones/create" class="btn-new">+ Nueva Inversión</a>

</div>

@if(session('success'))
<p style="color: green">{{ session('success') }}</p>
@endif



<hr>

<div class="inversion-grid">
    @foreach($inversiones as $inv)


    <div class="inversion-card">

        <div class="inversion-title">{{ $inv->nombre }}</div>

        <div class="inversion-title">
            Clave: {{ $inv->clave }}
        </div>

        <div class="inversion-info">
            📍 {{ $inv->ubicacion ?? 'N/A' }}<br>

            👥 Personas relacionadas:
            @if($inv->clientes->isEmpty())
            N/A
            @else
            <div style="margin-top:5px;">
                @foreach($inv->clientes as $cliente)
                <span style="background:#e5e7eb; padding:4px 8px; border-radius:12px; margin-right:5px;">
                    {{ $cliente->nombre }}
                </span>
                @endforeach
            </div>
            @endif
        </div>

@if(auth()->user()->tienePermiso($inv->id, 'avaluos'))

<div class="divider"></div>

<div class="section-title">💰 Perfil Financiero</div>

<div class="inversion-info">

    @if($inv->ultimoAvaluo)

        📅 Ultimo Avalúo:
        {{ $inv->ultimoAvaluo->fecha_avaluo }}
        <br>

        🌱 Terreno:
        $ {{ number_format($inv->ultimoAvaluo->subtotal_terreno, 2) }}
        <br>

        🏗️ Construcción:
        $ {{ number_format($inv->ultimoAvaluo->subtotal_construccion, 2) }}
        <br>

        📉 Depreciación:
        {{ number_format($inv->ultimoAvaluo->depreciacion, 2) }}
        <br>

        💰 Total:
        $ <strong>{{ number_format($inv->ultimoAvaluo->valor_total, 2) }}</strong>

    @else

        <span style="color:#9ca3af;">
            Sin avalúo registrado
        </span>

    @endif

</div>

@endif

@if(auth()->user()->tienePermiso($inv->id, 'servicios'))

<div class="divider"></div>

<div class="section-title">⚙️ Perfil Operativo</div>

<div class="inversion-info">

    Costo mensual:
    $ {{ number_format($inv->costo_operativo_mensual, 2) }}

    <br>

    Costo anual:
    $ {{ number_format($inv->costo_operativo_anual, 2) }}

</div>

@endif
@if(auth()->user()->tienePermiso($inv->id, 'estado_resultados'))

        <div class="divider"></div>

        <div class="section-title">
            📊 Estado de Resultados
        </div>

        <div class="inversion-info">

            @if($inv->ultimoEstadoResultado)

            Año:
            {{ $inv->ultimoEstadoResultado->anio }}
            <br>

            Utilidad Neta:
            <strong>
                L {{ number_format($inv->ultimoEstadoResultado->utilidad_neta,2) }}
            </strong>

            @else

            <span style="color:#9ca3af;">
                Sin Estado de Resultados
            </span>

            @endif

        </div>

            @endif
    
            @if(auth()->user()->tienePermiso($inv->id, 'entidades'))
        

        <div class="divider"></div>

        <div class="section-title">🏢 Entidades Relacionadas</div>

        <div class="inversion-info">

            @if($inv->entidades->isEmpty())

            <span style="color:#9ca3af;">
                Sin entidades registradas
            </span>

            @else

            @foreach($inv->entidades->take(3) as $entidad)

            <div style="margin-bottom:5px;">
                • {{ $entidad->denominacion_social }}
            </div>

            @endforeach

            @if($inv->entidades->count() > 3)

            <small style="color:#6b7280;">
                +{{ $inv->entidades->count() - 3 }} más...
            </small>

            @endif

            @endif

        </div>


            @endif

            
@if(auth()->user()->tienePermiso($inv->id, 'activos_registrales'))

<div class="divider"></div>

<div class="section-title">
    📑 Perfil Registral
</div>

<div class="inversion-info">

    @if($inv->activosRegistrales->isEmpty())

        <span style="color:#9ca3af;">
            Sin activos registrales
        </span>

    @else

        @foreach($inv->activosRegistrales->take(3) as $activo)

            <div style="margin-bottom:5px;">

                • Matrícula:
                {{ $activo->numero_matricula }}

            </div>

        @endforeach

        @if($inv->activosRegistrales->count() > 3)

            <small style="color:#6b7280;">
                +{{ $inv->activosRegistrales->count() - 3 }} más...
            </small>

        @endif

    @endif

</div>

@endif

        <div class="divider"></div>

        <div class="actions">

            @if(auth()->user()->tienePermiso($inv->id, 'avaluos'))
            <a href="/inversiones/{{ $inv->id }}/avaluos">
                📊 Avalúos
            </a>
            @endif

            @if(auth()->user()->tienePermiso($inv->id, 'activos'))
            <a href="/inversiones/{{ $inv->id }}/assets">
                🏢 Activos
            </a>
            @endif

            @if(auth()->user()->tienePermiso($inv->id, 'servicios'))
            <a href="/inversiones/{{ $inv->id }}/servicios">
                ⚙️ Servicios
            </a>
            @endif

            @if(auth()->user()->tienePermiso($inv->id, 'comercial'))
            <a href="/inversiones/{{ $inv->id }}/comercial">
                💰 Comercial
            </a>
            @endif

            @if(auth()->user()->tienePermiso($inv->id, 'entidades'))
            <a href="/inversiones/{{ $inv->id }}/entidades">
                🏢 Entidades
            </a>
            @endif

        @if(auth()->user()->tienePermiso($inv->id, 'activos_registrales'))

<a href="/inversiones/{{ $inv->id }}/activos-registrales">
    📑 Activos Registrales
</a>

@endif
            @if(auth()->user()->tienePermiso($inv->id, 'estado_resultados'))
            <a href="/inversiones/{{ $inv->id }}/estado-resultados">
                📊 Estado Resultado
            </a>
            @endif

            @if(auth()->user()->role == 'admin')

            <a href="/inversiones/{{ $inv->id }}/edit">
                ✏️ Editar
            </a>

            <form action="/inversiones/{{ $inv->id }}"
                method="POST"
                style="display:inline;"
                onsubmit="event.preventDefault(); confirmarEliminacion(this)">

                @csrf
                @method('DELETE')

                <button type="submit"
                    class="btn-danger">

                    🗑️ Eliminar

                </button>

            </form>

            @endif

        </div>

    </div> {{-- ← cierre inversion-card --}}

    @endforeach

</div>

@endsection