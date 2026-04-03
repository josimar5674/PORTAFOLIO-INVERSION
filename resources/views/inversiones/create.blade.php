<h1>Crear Inversión</h1>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/inversiones">
    @csrf

    <input type="text" name="nombre" placeholder="Nombre"><br>
    <input type="text" name="ubicacion" placeholder="Ubicación"><br>
    <textarea name="descripcion" placeholder="Descripción"></textarea><br>

    <label>Cliente:</label>
    <select name="cliente_id">
        @foreach($clientes as $cliente)
            <option value="{{ $cliente->id }}">
                {{ $cliente->nombre }}
            </option>
        @endforeach
    </select><br>

    <button type="submit">Guardar</button>
</form>