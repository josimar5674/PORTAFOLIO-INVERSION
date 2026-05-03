@extends('layouts.app')

@section('content')

<h2 style="margin-left:15px;">💰 Perfil Comercial</h2>


<!-- 🔙 VOLVER -->
<div style="margin-left:15px; margin-bottom:10px;">

   <a href="/inversiones" class="btn-secondary">← Volver a Inversiones</a>

</div>
<div style="margin-left:15px;">
    <a href="/inversiones/{{ $inversion_id }}/comercial/create" class="btn-new">
        + Nuevo Registro
    </a>
</div>


<!-- 🔥 TOTAL -->
<div style="margin:15px;">
    <strong>
        Total Comercial: L {{ number_format($items->sum('subtotal'), 2) }}
    </strong>
</div>


<!-- CONTENEDOR -->
<div style="
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 15px;
">
@foreach($items as $item)

    <div style="
        background:white;
        border-radius:12px;
        padding:15px;
        box-shadow:0 4px 10px rgba(0,0,0,0.05);
        border:1px solid #f1f5f9;
    ">

        <!-- 🔹 TÍTULO -->
        <div style="font-weight:600; margin-bottom:8px;">
            {{ $item->producto ?? 'Sin producto' }}
        </div>

        <!-- 🔹 INFO -->
        <div style="font-size:14px; color:#374151;">
            👤 Cliente: {{ $item->cliente ?? 'N/A' }} <br>
            📦 Cantidad: {{ number_format($item->cantidad, 2) }} <br>
            📏 Unidad: {{ $item->unidad ?? 'N/A' }} <br><br>

            💵 Precio: L {{ number_format($item->precio_unitario, 2) }} <br>
            💰 Subtotal: <strong>L {{ number_format($item->subtotal, 2) }}</strong>
        </div>

        <div style="border-top:1px solid #e5e7eb; margin:10px 0;"></div>

        <!-- 🔹 ACCIONES -->
        <div style="display:flex; justify-content:space-between; align-items:center;">

            <a href="/inversiones/{{ $inversion_id }}/comercial/{{ $item->id }}/edit">
                ✏️ Editar
            </a>

            <form method="POST"
                  action="/inversiones/{{ $inversion_id }}/comercial/{{ $item->id }}"
                  onsubmit="return confirm('⚠️ Esta acción no se puede deshacer.\n\n¿Eliminar este registro?')">

                @csrf
                @method('DELETE')

                <button type="submit"
                    style="background:#ef4444; color:white; border:none; padding:4px 8px; border-radius:6px; cursor:pointer;">
                    🗑️
                </button>

            </form>

        </div>

    </div>

@endforeach

  
</div>

@endsection