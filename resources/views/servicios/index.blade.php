<h1>Servicios</h1>

<a href="/inversiones/{{ $inversion_id }}/servicios/create">Nuevo Servicio</a>

<ul>
@foreach($servicios as $servicio)
    <li>
        {{ $servicio->nombre }} - L {{ number_format($servicio->costo_mensual, 2) }}

        <a href="/inversiones/{{ $inversion_id }}/servicios/{{ $servicio->id }}/edit">Editar</a>

        <form method="POST" action="/inversiones/{{ $inversion_id }}/servicios/{{ $servicio->id }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Eliminar</button>
        </form>
    </li>
@endforeach
</ul>