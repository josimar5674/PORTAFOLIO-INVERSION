<h1>Clientes</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<a href="/clientes/create">Nuevo Cliente</a>

<ul>
@foreach($clientes as $cliente)
    <li>
        {{ $cliente->nombre }} - {{ $cliente->tipo }}

        <a href="/clientes/{{ $cliente->id }}/edit">Editar</a>

        <form action="/clientes/{{ $cliente->id }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Eliminar</button>
        </form>
    </li>
@endforeach
</ul>