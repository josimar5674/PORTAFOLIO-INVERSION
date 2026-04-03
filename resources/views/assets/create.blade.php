<h1>Crear Activo</h1>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/inversiones/{{ $investment_id }}/assets">
    @csrf

    <input type="hidden" name="investment_id" value="{{ $investment_id }}">

    <input type="text" name="name" placeholder="Nombre del nivel (Ej: Nivel 1)"><br>

    <input type="number" name="level_number" placeholder="Número de nivel"><br>

    <input type="text" name="type" placeholder="Tipo (residencial/comercial/parqueo)"><br>

    <input type="number" step="0.01" name="area" placeholder="Área en m²"><br>

    <input type="number" name="units" placeholder="Cantidad de unidades"><br>

    <textarea name="description" placeholder="Descripción"></textarea><br>

    <select name="status">
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
    </select><br>

    <button type="submit">Guardar</button>
</form>