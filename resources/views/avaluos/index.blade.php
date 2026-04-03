<h1>Avalúos</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<a href="/inversiones/{{ $inversion_id }}/avaluos/create">Nuevo Avalúo</a>

<ul>
@foreach($avaluos as $avaluo)
    <li>
        Terreno: {{ $avaluo->valor_terreno }} | 
        Construcción: {{ $avaluo->valor_construccion }} | 
        Total: {{ $avaluo->valor_total }} | 
        Fecha: {{ $avaluo->fecha_avaluo }}

        <a href="/inversiones/{{ $inversion_id }}/avaluos/{{ $avaluo->id }}/edit">Editar</a>

        <form action="/inversiones/{{ $inversion_id }}/avaluos/{{ $avaluo->id }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Eliminar</button>
        </form>
    </li>
@endforeach
</ul>