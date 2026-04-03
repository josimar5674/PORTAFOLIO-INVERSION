<h1>Activos</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<a href="/inversiones/{{ $investment_id }}/assets/create">Nuevo Activo</a>

<ul>
@foreach($assets as $asset)
    <li>
        {{ $asset->name }} - {{ $asset->type }} - Nivel {{ $asset->level_number }}

        <a href="/inversiones/{{ $investment_id }}/assets/{{ $asset->id }}/edit">Editar</a>

        <form action="/inversiones/{{ $investment_id }}/assets/{{ $asset->id }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Eliminar</button>
        </form>
    </li>
@endforeach
</ul>