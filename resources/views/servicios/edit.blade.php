<h1>Editar Servicio</h1>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/inversiones/{{ $servicio->inversion_id }}/servicios/{{ $servicio->id }}">
    @csrf
    @method('PUT')

    <input type="hidden" name="inversion_id" value="{{ $servicio->inversion_id }}">

    <input type="text" name="nombre" value="{{ $servicio->nombre }}" placeholder="Nombre del servicio"><br>

    <input type="number" step="0.01" name="costo_mensual" value="{{ $servicio->costo_mensual }}" placeholder="Costo mensual"><br>

    <input type="text" name="tipo" value="{{ $servicio->tipo }}" placeholder="Tipo"><br>

    <textarea name="descripcion" placeholder="Descripción">{{ $servicio->descripcion }}</textarea><br>

    <button type="submit">Actualizar</button>
</form>