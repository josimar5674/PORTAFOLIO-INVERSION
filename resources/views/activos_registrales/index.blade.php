@extends('layouts.app')

@section('content')

<h2 style="margin-left:15px;">
    🏢 Activos Registrales
</h2>

<div style="margin-left:15px; margin-bottom:15px;">

    <a href="/inversiones"
       class="btn-secondary">
        ← Volver
    </a>

    <a href="/inversiones/{{ $inversion->id }}/activos-registrales/create"
       class="btn-new">
        + Nuevo Activo
    </a>

</div>

<div style="
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(380px,1fr));
    gap:20px;
    padding:15px;
">

@foreach($activos as $activo)

<div style="
    background:white;
    border-radius:12px;
    padding:20px;
    box-shadow:0 2px 8px rgba(0,0,0,0.05);
">

    <div style="font-size:18px; font-weight:600; margin-bottom:15px;">
        Matrícula: {{ $activo->numero_matricula }}
    </div>

    <div style="font-size:14px; color:#4b5563;">

        📍 {{ $activo->ubicacion_inmueble }}
        <br><br>

        🏙️ {{ $activo->ciudad }}
        <br><br>

        💰 $ {{ number_format($activo->valor_escrituracion, 2) }}
        <br><br>

        🧾 {{ $activo->clave_catastral_municipal }}
        <br><br>

        🏘️ {{ $activo->zonificacion }}
        <br><br>

        📑 Inscripciones:
        {{ $activo->inscripciones->count() }}

    </div>

    <div style="
        border-top:1px solid #e5e7eb;
        margin:15px 0;
    "></div>

    <div style="display:flex; justify-content:space-between;">

        <a href="/activos-registrales/{{ $activo->id }}/edit">
            ✏️ Editar
        </a>

        <form method="POST"
              action="/activos-registrales/{{ $activo->id }}"
              onsubmit="return confirm('¿Eliminar activo?')">

            @csrf
            @method('DELETE')

            <button type="submit"
                    style="
                        background:#ef4444;
                        color:white;
                        border:none;
                        padding:5px 10px;
                        border-radius:6px;
                    ">
                🗑️
            </button>

        </form>

    </div>

</div>

@endforeach

</div>

@endsection