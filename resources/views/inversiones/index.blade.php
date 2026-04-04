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

    <div class="inversion-info">
        📍 {{ $inv->ubicacion }}<br>
        👤 Cliente: {{ $inv->cliente->nombre ?? 'N/A' }}
    </div>

    <div class="divider"></div>

    <div class="section-title">💰 Perfil Financiero</div>
    <div class="inversion-info">
        Terreno: {{ number_format($inv->valor_terreno, 2) }}<br>
        Construcción: {{ number_format($inv->valor_construccion, 2) }}<br>
        Total: {{ number_format($inv->valor_total, 2) }}<br>
        Depreciación: {{ number_format($inv->depreciacion_anual, 2) }}<br>
        Valor Neto: {{ number_format($inv->valor_neto, 2) }}
    </div>

    <div class="divider"></div>

    <div class="section-title">⚙️ Perfil Operativo</div>
    <div class="inversion-info">
        Costo mensual: {{ number_format($inv->costo_operativo_mensual, 2) }}<br>
        Costo anual: {{ number_format($inv->costo_operativo_anual, 2) }}
    </div>

    <div class="divider"></div>

    <div class="actions">
        <a href="/inversiones/{{ $inv->id }}/avaluos">📊 Avalúos</a>
        <a href="/inversiones/{{ $inv->id }}/assets">🏢 Activos</a>
        <a href="/inversiones/{{ $inv->id }}/servicios">⚙️ Servicios</a>
        <a href="/inversiones/{{ $inv->id }}/edit">✏️ Editar</a>

        <form action="/inversiones/{{ $inv->id }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">🗑️ Eliminar</button>
        </form>
    </div>
  </div>
    </div>

</li>
@endforeach
</ul>

@endsection