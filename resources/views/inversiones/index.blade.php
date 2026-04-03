<h1>Inversiones</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<a href="/inversiones/create">Nueva Inversión</a>

<hr>

<ul>
@foreach($inversiones as $inv)
    <li style="margin-bottom:20px; border:1px solid #ccc; padding:10px;">

        <b>{{ $inv->nombre }}</b><br>
        📍 {{ $inv->ubicacion }}<br>
        👤 Cliente: {{ $inv->cliente->nombre ?? 'N/A' }}<br>

        <hr>

        <!-- 💰 PERFIL FINANCIERO -->
        <b>Perfil Financiero:</b><br>
        💰 Terreno: {{ number_format($inv->valor_terreno, 2) }}<br>
        🏗️ Construcción: {{ number_format($inv->valor_construccion, 2) }}<br>
        💵 Total: {{ number_format($inv->valor_total, 2) }}<br>
        📉 Depreciación: {{ number_format($inv->depreciacion_anual, 2) }}<br>
        📊 Valor Neto: {{ number_format($inv->valor_neto, 2) }}<br>

        <hr>

        <hr>

<!-- ⚙️ PERFIL OPERATIVO -->
<b>Perfil Operativo:</b><br>
⚙️ Costo mensual: {{ number_format($inv->costo_operativo_mensual, 2) }}<br>
📅 Costo anual: {{ number_format($inv->costo_operativo_anual, 2) }}<br>

        <!-- 🔗 ACCIONES -->
        <a href="/inversiones/{{ $inv->id }}/avaluos">📊 Avalúos</a> |
        <a href="/inversiones/{{ $inv->id }}/assets">🏢 Activos</a> |
        <a href="/inversiones/{{ $inv->id }}/servicios">⚙️ Servicios</a> |
        <a href="/inversiones/{{ $inv->id }}/edit">✏️ Editar</a>

        <form action="/inversiones/{{ $inv->id }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">🗑️ Eliminar</button>
        </form>

    </li>
@endforeach
</ul>