<h1>Editar Avalúo</h1>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/inversiones/{{ $avaluo->inversion_id }}/avaluos/{{ $avaluo->id }}">
    @csrf
    @method('PUT')

    <input type="hidden" name="inversion_id" value="{{ $avaluo->inversion_id }}">

    <input type="number" step="0.01" name="valor_terreno" value="{{ $avaluo->valor_terreno }}" placeholder="Valor del terreno"><br>

    <input type="number" step="0.01" name="valor_construccion" value="{{ $avaluo->valor_construccion }}" placeholder="Valor de construcción"><br>

    <input type="date" name="fecha_avaluo" value="{{ $avaluo->fecha_avaluo }}"><br>

    <textarea name="observaciones" placeholder="Observaciones">{{ $avaluo->observaciones }}</textarea><br>

    <button type="submit">Actualizar</button>
</form>