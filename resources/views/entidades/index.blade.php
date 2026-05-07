@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/entidades.css') }}">

@section('content')

<h2 style="margin-left:15px;">🏢 Entidades</h2>

<div style="margin-left:15px; margin-bottom:10px;">
   <a href="/" class="btn-secondary">
       ← Volver al Dashboard
   </a>
</div>

<div style="margin-left:15px;">
    <a href="/entidades/create"
       class="btn-new">
        + Nueva Entidad
    </a>
</div>

<div style="
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(350px,1fr));
    gap:20px;
    padding:15px;
">

@foreach($entidades as $entidad)

<div style="
    background:white;
    border-radius:12px;
    padding:20px;
    box-shadow:0 2px 8px rgba(0,0,0,0.05);
">

    <!-- TÍTULO -->
    <div style="
        font-size:18px;
        font-weight:600;
        margin-bottom:10px;
    ">
        {{ $entidad->denominacion_social }}
    </div>

    <!-- INFO -->
    <div style="color:#4b5563; font-size:14px;">

        🆔 RTN:
        {{ $entidad->identificador_tributario ?? 'N/A' }}
        <br><br>

        🏛️ Tipo:
        {{ $entidad->tipo_societario ?? 'N/A' }}
        <br><br>

        👔 Gerente:
        {{ $entidad->gerente_general ?? 'N/A' }}
        <br><br>

        📅 Constitución:
        {{ $entidad->fecha_constitucion ?? 'N/A' }}
        <br><br>

        💰 Capital:
        $ {{ number_format($entidad->capital_social_max ?? 0, 2) }}

        <br><br>

        🏢 Inversiones Relacionadas:
        {{ $entidad->inversiones->count() }}

    </div>

    <div style="
        border-top:1px solid #e5e7eb;
        margin:15px 0;
    "></div>

    <!-- ACCIONES -->
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
    ">

        <a href="/entidades/{{ $entidad->id }}/edit">
            ✏️ Editar
        </a>

        <form method="POST"
              action="/entidades/{{ $entidad->id }}"
              onsubmit="return confirm('¿Eliminar esta entidad?')">

            @csrf
            @method('DELETE')

            <button type="submit"
                style="
                    background:#ef4444;
                    color:white;
                    border:none;
                    padding:5px 10px;
                    border-radius:6px;
                    cursor:pointer;
                ">
                🗑️
            </button>

        </form>

    </div>

</div>

@endforeach

</div>

@endsection