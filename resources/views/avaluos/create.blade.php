<h1>Nuevo Avalúo</h1>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/inversiones/{{ $inversion_id }}/avaluos">
    @csrf

    <input type="hidden" name="inversion_id" value="{{ $inversion_id }}">

    <input type="number" step="0.01" name="valor_terreno" placeholder="Valor del terreno"><br>

    <input type="number" step="0.01" name="valor_construccion" placeholder="Valor de construcción"><br>

    <input type="date" name="fecha_avaluo"><br>

    <textarea name="observaciones" placeholder="Observaciones"></textarea><br>

    <button type="submit">Guardar</button>
</form>