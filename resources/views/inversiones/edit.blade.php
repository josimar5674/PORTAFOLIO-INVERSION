<h1>Editar Inversión</h1>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/inversiones/{{ $inversion->id }}">
    @csrf
    @method('PUT')

    <input type="text" name="nombre" value="{{ $inversion->nombre }}"><br>
    <input type="text" name="ubicacion" value="{{ $inversion->ubicacion }}"><br>
    <textarea name="descripcion">{{ $inversion->descripcion }}</textarea><br>

    <label>Cliente:</label>
    <select name="cliente_id">
        @foreach($clientes as $cliente)
            <option value="{{ $cliente->id }}"
                {{ $cliente->id == $inversion->cliente_id ? 'selected' : '' }}>
                {{ $cliente->nombre }}
            </option>
        @endforeach
    </select><br>

    <button type="submit">Actualizar</button>
</form>