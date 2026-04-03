<h1>Crear Cliente</h1>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/clientes">
    @csrf

    <input type="text" name="nombre" placeholder="Nombre"><br>
    <input type="text" name="tipo" placeholder="Tipo (natural/juridico)"><br>
    <input type="text" name="identificacion" placeholder="Identificación"><br>
    <input type="text" name="telefono" placeholder="Teléfono"><br>
    <input type="email" name="email" placeholder="Email"><br>

    <button type="submit">Guardar</button>
</form>