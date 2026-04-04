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




@if(session('success'))
    <div class="alert alert-success" style="margin-left:15px;">
        {{ session('success') }}
    </div>
@endif

<div style="margin-left:15px;">
    <a href="/inversiones/{{ $inversion_id }}/avaluos/create" class="btn-new">
        + Nuevo Avalúo
    </a>
</div>

<!-- CONTENEDOR -->
<div class="container custom-container">

    <div class="row">

        @foreach($avaluos as $avaluo)

            <div class="col-md-6">
                <div class="avaluo-card">

                    <div class="avaluo-title">
                        📅 {{ $avaluo->fecha_avaluo }}
                    </div>

                    <div class="avaluo-info">
                        💰 Terreno: {{ number_format($avaluo->valor_terreno, 2) }}<br>
                        🏗️ Construcción: {{ number_format($avaluo->valor_construccion, 2) }}<br>
                        💵 Total: {{ number_format($avaluo->valor_total, 2) }}
                    </div>

                    <div class="divider"></div>

                    <div class="avaluo-actions">

                        <a href="/inversiones/{{ $inversion_id }}/avaluos/{{ $avaluo->id }}/edit">
                            ✏️ Editar
                        </a>

                        <form action="/inversiones/{{ $inversion_id }}/avaluos/{{ $avaluo->id }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">🗑️ Eliminar</button>
                        </form>

                    </div>

                </div>
            </div>

        @endforeach

    </div>

</div>

@endsection