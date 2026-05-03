@extends('layouts.app')

@section('content')

<h2 style="margin-left:15px;">📊 Avalúos</h2>
<!-- 🔙 VOLVER -->

<h4 style="margin-left:15px; color:#555;">
    Total avalúos: {{ count($avaluos) }}
</h4>
<div style="margin-left:15px; margin-bottom:10px;">
    <a href="/inversiones/" class="btn-secondary">
        ← Volver a la Inversión
    </a>
</div>
<br>
<div style="margin-left:15px;">
    <a href="/inversiones/{{ $inversion_id }}/avaluos/create" class="btn-new">
        + Nuevo Avalúo
    </a>
</div>



@if(session('success'))
    <div class="alert alert-success" style="margin-left:15px;">
        {{ session('success') }}
    </div>
@endif



<!-- CONTENEDOR -->
<div class="container custom-container">

    <div class="row">
@foreach($avaluos as $avaluo)

<div class="col-md-6">
    <div class="avaluo-card">

        <!-- 📅 FECHA -->
        <div class="avaluo-title">
            📅 {{ \Carbon\Carbon::parse($avaluo->fecha_avaluo)->format('d/m/Y') }}
        </div>

        <!-- 💰 INFO -->
        <div class="avaluo-info">

            🌱 Terreno: 
            {{ number_format($avaluo->subtotal_terreno, 2) }}
            ({{ $avaluo->unidad_terreno }}) <br>

            🏗️ Construcción: 
            {{ number_format($avaluo->subtotal_construccion, 2) }} <br>

            📉 Depreciación: 
            {{ number_format($avaluo->depreciacion, 2) }} <br><br>

            💵 <strong>Total: {{ number_format($avaluo->valor_total, 2) }}</strong>

            
        </div>

        <!-- 📝 OBSERVACIONES -->
        @if($avaluo->observaciones)
            <div style="margin-top:10px; font-size:13px; color:#555;">
                📝 {{ $avaluo->observaciones }}
            </div>
        @endif

        <div class="divider"></div>

        <!-- 🔧 ACCIONES -->
        <div class="avaluo-actions">

            <a href="/inversiones/{{ $inversion_id }}/avaluos/{{ $avaluo->id }}/edit">
                ✏️ Ver/Editar
            </a>

            <form action="/inversiones/{{ $inversion_id }}/avaluos/{{ $avaluo->id }}" 
                  method="POST" 
                  style="display:inline;"
                  onsubmit="return confirm('¿Seguro que deseas eliminar este avalúo?')">

                @csrf
                @method('DELETE')

                <button type="submit">🗑️ Eliminar</button>
            </form>

        </div>

    </div>
    <br>
</div>



@endforeach

    </div>

</div>

@endsection