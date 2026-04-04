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

<!-- CONTENEDOR -->
<div class="container custom-container">

    <div class="row">

        @foreach($servicios as $servicio)

            <div class="col-md-6">
                <div class="servicio-card">

                    <div class="servicio-title">
                        {{ $servicio->nombre }}
                    </div>

                    <div class="servicio-info">
                        💰 Costo mensual: L {{ number_format($servicio->costo_mensual, 2) }}
                    </div>

                    <div class="divider"></div>

                    <div class="servicio-actions">

                        <a href="/inversiones/{{ $inversion_id }}/servicios/{{ $servicio->id }}/edit">
                            ✏️ Editar
                        </a>

                        <form method="POST" action="/inversiones/{{ $inversion_id }}/servicios/{{ $servicio->id }}" style="display:inline;">
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