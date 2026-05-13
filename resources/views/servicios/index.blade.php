@extends('layouts.app')

@section('content')

<h2 style="margin-left:15px;">⚙️ Servicios</h2>

<!-- 🔙 VOLVER -->
<div style="margin-left:15px; margin-bottom:10px;">
   <a href="/inversiones" class="btn-secondary">← Volver a Inversiones</a>
</div>

<div style="margin-left:15px;">
    <a href="/inversiones/{{ $inversion_id }}/servicios/create" class="btn-new">
        + Nuevo Servicio
    </a>
</div>

<!-- 🔥 TOTAL -->
<div style="margin:15px;">
    <strong>
        Total mensual: $ {{ number_format($servicios->sum('costo_mensual'), 2) }} <br>
        Total anual: $ {{ number_format($servicios->sum('costo_anual'), 2) }}
    </strong>
</div>

<!-- CONTENEDOR -->
<!-- GRID -->
<div class="card-grid">

    @foreach($servicios as $servicio)

        <div class="card">

            <!-- TITULO -->
            <div class="card-title">

                {{ $servicio->clave ?? 'N/A' }}
                -
                {{ $servicio->servicio ?? 'Sin nombre' }}

            </div>

            <!-- INFO -->
            <div class="card-info">

                👤 Prestador:
                {{ $servicio->prestador ?? 'N/A' }}

                <br><br>

                📂 Categoría:
                {{ $servicio->categoria ?? 'N/A' }}

                <br><br>

                🔗 Relación:
                {{ $servicio->relacion ?? 'N/A' }}

                <br><br>

                💰 Mensual:
                $ {{ number_format($servicio->costo_mensual, 2) }}

                <br>

                📆 Anual:
                $ {{ number_format($servicio->costo_anual, 2) }}

            </div>

            <div class="divider"></div>

            <!-- ACCIONES -->
            <div class="card-actions">

                <a href="/inversiones/{{ $inversion_id }}/servicios/{{ $servicio->id }}/edit">

                    ✏️ Editar

                </a>

                <form method="POST"
                      action="/inversiones/{{ $inversion_id }}/servicios/{{ $servicio->id }}"
                      style="display:inline;"
                      onsubmit="event.preventDefault(); confirmarEliminacion(this)">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn-danger">

                        🗑️ Eliminar

                    </button>

                </form>

            </div>

        </div>

    @endforeach

</div>

@endsection