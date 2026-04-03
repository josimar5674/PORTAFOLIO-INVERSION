<h1>Editar Activo</h1>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/inversiones/{{ $asset->investment_id }}/assets/{{ $asset->id }}">
    @csrf
    @method('PUT')

    <input type="hidden" name="investment_id" value="{{ $asset->investment_id }}">

    <input type="text" name="name" value="{{ $asset->name }}" placeholder="Nombre del nivel"><br>

    <input type="number" name="level_number" value="{{ $asset->level_number }}" placeholder="Número de nivel"><br>

    <input type="text" name="type" value="{{ $asset->type }}" placeholder="Tipo"><br>

    <input type="number" step="0.01" name="area" value="{{ $asset->area }}" placeholder="Área en m²"><br>

    <input type="number" name="units" value="{{ $asset->units }}" placeholder="Cantidad de unidades"><br>

    <textarea name="description" placeholder="Descripción">{{ $asset->description }}</textarea><br>

    <select name="status">
        <option value="1" {{ $asset->status ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ !$asset->status ? 'selected' : '' }}>Inactivo</option>
    </select><br>

    <button type="submit">Actualizar</button>
</form>