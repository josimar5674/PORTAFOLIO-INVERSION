<h1>Nuevo Servicio</h1>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/inversiones/{{ $inversion_id }}/servicios">
    @csrf

    <input type="hidden" name="inversion_id" value="{{ $inversion_id }}">

    <input type="text" name="nombre" placeholder="Nombre del servicio (Ej: ENEE)"><br>

    <input type="number" step="0.01" name="costo_mensual" placeholder="Costo mensual"><br>

    <input type="text" name="tipo" placeholder="Tipo (Ej: Energía, Agua, Internet)"><br>

    <textarea name="descripcion" placeholder="Descripción"></textarea><br>

    <button type="submit">Guardar</button>
</form>