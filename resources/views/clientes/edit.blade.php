<h1>Editar Cliente</h1>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/clientes/{{ $cliente->id }}">
    @csrf
    @method('PUT')

    <input type="text" name="nombre" value="{{ $cliente->nombre }}"><br>
    <input type="text" name="tipo" value="{{ $cliente->tipo }}"><br>
    <input type="text" name="identificacion" value="{{ $cliente->identificacion }}"><br>
    <input type="text" name="telefono" value="{{ $cliente->telefono }}"><br>
    <input type="email" name="email" value="{{ $cliente->email }}"><br>

    <button type="submit">Actualizar</button>
</form>