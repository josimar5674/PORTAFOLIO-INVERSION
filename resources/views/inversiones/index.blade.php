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
<div class="row">
@foreach($inversiones as $inv)

    <div class="col-md-6">
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

    <div class="divider"></div>

    <div class="section-title">💰 Perfil Financiero</div>
 <div class="inversion-info">

    @if($inv->ultimoAvaluo)

    📅 Ultimo Avalúo: {{ $inv->ultimoAvaluo?->fecha_avaluo ?? 'Sin avalúo' }} <br>

        🌱 Terreno: $

        {{ number_format($inv->ultimoAvaluo->subtotal_terreno, 2) }} <br>

        🏗️ Construcción: $

        {{ number_format($inv->ultimoAvaluo->subtotal_construccion, 2) }} <br>

        📉 Depreciación: 

        {{ number_format($inv->ultimoAvaluo->depreciacion, 2) }} <br>

        💰 Total: $

        <strong>{{ number_format($inv->ultimoAvaluo->valor_total, 2) }}</strong>

    @else

        <span style="color:#9ca3af;">Sin avalúo registrado</span>

    @endif
    

</div>

    <div class="divider"></div>

    <div class="section-title">⚙️ Perfil Operativo</div>
    <div class="inversion-info">
        Costo mensual: {{ number_format($inv->costo_operativo_mensual, 2) }}<br>
        Costo anual: {{ number_format($inv->costo_operativo_anual, 2) }}
    </div>

    <div class="divider"></div>

<div class="section-title">💰 Perfil Comercial</div>

<div class="inversion-info">

    @if($inv->comercial->isEmpty())

        <span style="color:#9ca3af;">Sin registros comerciales</span>

    @else

        💵 Total ingresos: 
        <strong>
            L {{ number_format($inv->comercial->sum('subtotal'), 2) }}
        </strong>

        <div style="margin-top:5px;">
            @foreach($inv->comercial->take(3) as $item)
                <div style="font-size:13px; color:#4b5563;">
                    • {{ $item->producto }} 
                    (L {{ number_format($item->subtotal, 2) }})
                </div>
            @endforeach

            @if($inv->comercial->count() > 3)
                <small style="color:#6b7280;">
                    +{{ $inv->comercial->count() - 3 }} más...
                </small>
            @endif
        </div>

    @endif

</div>

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

    <div class="divider"></div>

    <div class="actions">
        <a href="/inversiones/{{ $inv->id }}/avaluos">📊 Avalúos</a>
        <a href="/inversiones/{{ $inv->id }}/assets">🏢 Activos</a>
        <a href="/inversiones/{{ $inv->id }}/servicios">⚙️ Servicios</a>
        <a href="/inversiones/{{ $inv->id }}/comercial">💰 Comercial</a>
       <a href="/inversiones/{{ $inv->id }}/entidades">

    🏢 Entidades

</a>
        <a href="/inversiones/{{ $inv->id }}/edit">✏️ Editar</a>
    

       <form action="/inversiones/{{ $inv->id }}" method="POST" style="display:inline;"
      onsubmit="return confirm('⚠️ Esta acción no se puede deshacer.\n\n¿Seguro que deseas eliminar esta inversión?')">
    @csrf
    @method('DELETE')
 <button type="submit"
    style="background:#feb4ff; color:white; border:none; padding:5px 10px; border-radius:6px; cursor:pointer;">
    🗑️ Eliminar
</button>
</form>
    </div>
  </div>
    </div>

</li>
@endforeach
</ul>

@endsection