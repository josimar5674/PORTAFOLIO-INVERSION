@extends('layouts.app')

@section('content')

@php

    $ultimoAvaluo = $avaluos->first();

    $totalValor = $avaluos->sum('valor_total');

    $promedioValor =
        $avaluos->count() > 0
        ? $totalValor / $avaluos->count()
        : 0;

    $valorMaximo =
        $avaluos->max('valor_total');

@endphp

<div class="investment-header">

    <div>

        <h1>
            📊 Avalúos
        </h1>

        <small>
            {{ $avaluos->count() }} registros
        </small>

    </div>

    <div>

   <a href="/inversiones/{{ $inversion_id }}"
   class="btn-secondary">

    ← Volver

</a>

<button
    type="button"
    class="btn-primary-custom"
    onclick="abrirModal(
        'modalAvaluo',
        '/inversiones/{{ $inversion_id }}/avaluos/create'
    )">

    + Nuevo Avalúo

</button>

    </div>

</div>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif


<div class="summary-grid">

    <div class="summary-card">

        📊 Total Avalúos

        <strong>

            {{ $avaluos->count() }}

        </strong>

    </div>

    <div class="summary-card">

        📅 Último Avalúo

        <strong>

            {{ $ultimoAvaluo?->fecha_avaluo ?? 'N/A' }}

        </strong>

    </div>

    <div class="summary-card">

        💰 Valor Actual

        <strong>

            $
            {{ number_format($ultimoAvaluo?->valor_total ?? 0,0) }}

        </strong>

    </div>

    <div class="summary-card">

        📈 Valor Promedio

        <strong>

            $
            {{ number_format($promedioValor,0) }}

        </strong>

    </div>

    <div class="summary-card">

        🏆 Valor Máximo

        <strong>

            $
            {{ number_format($valorMaximo,0) }}

        </strong>

    </div>

</div>


<div style="overflow-x:auto; margin-top:25px;">

    <table class="table-dashboard">

        <thead>

            <tr>

                <th>Fecha</th>

                <th>Terreno</th>

                <th>Edificios</th>

                <th>Depreciación</th>

                <th>Valor Total</th>

                <th>Observaciones</th>

                <th>Acciones</th>

            </tr>

        </thead>

        <tbody>

            @foreach($avaluos as $avaluo)

            <tr>

                <td>

                    {{ \Carbon\Carbon::parse($avaluo->fecha_avaluo)->format('d/m/Y') }}

                </td>

                <td>

                    $ {{ number_format($avaluo->subtotal_terreno,2) }}

                </td>

                <td>

                    $ {{ number_format($avaluo->subtotal_construccion,2) }}

                </td>

                <td>

                    $ {{ number_format($avaluo->depreciacion,2) }}

                </td>

                <td style="
                    font-weight:bold;
                    color:#16a34a;
                ">

                    $ {{ number_format($avaluo->valor_total,2) }}

                </td>

                <td>

                    {{ \Illuminate\Support\Str::limit($avaluo->observaciones,50) }}

                </td>

                <td>

           <button
    type="button"
    class="btn-secondary"
    onclick="abrirModal(
        'modalAvaluo',
        '/inversiones/{{ $inversion_id }}/avaluos/{{ $avaluo->id }}/edit'
    )">

    Ver

</button>

                    <form action="/inversiones/{{ $inversion_id }}/avaluos/{{ $avaluo->id }}"
                          method="POST"
                          style="display:inline;"
                          onsubmit="event.preventDefault(); confirmarEliminacion(this)">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn-danger">

                            🗑️

                        </button>

                    </form>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>
<x-modal
    id="modalAvaluo"
    title="Avalúo">

    <div id="contenedorFormularioAvaluo">

        <!-- Aquí se cargará el formulario -->

    </div>

</x-modal>
@endsection



<script>
    let unidadActual = 'm2';

    // 🔄 CAMBIAR UNIDAD
    function cambiarUnidad(select) {
        unidadActual = select.value;

        document.getElementById('unidad_terreno').value = unidadActual;

        // limpiar campos
        document.getElementById('area_terreno').value = '';
        document.getElementById('precio_terreno').value = '';
        document.getElementById('subtotal_terreno').value = '';

        document.getElementById('conversionInfo').innerText = '';

        calcularTotal();
    }

    // 🌱 TERRENO (CONVERSIÓN AUTOMÁTICA)
    function calcularTerreno() {
        let area = parseFloat(document.getElementById('area_terreno').value) || 0;
        let precio = parseFloat(document.getElementById('precio_terreno').value) || 0;

        let areaEnM2 = area;

        if (unidadActual === 'v2') {
            areaEnM2 = area * 0.6987;

            document.getElementById('conversionInfo').innerText =
                `${area} v² ≈ ${areaEnM2.toFixed(2)} m²`;

        } else {
            const areaEnV2 = area * 1.43;

            document.getElementById('conversionInfo').innerText =
                `${area} m² ≈ ${areaEnV2.toFixed(2)} v²`;
        }

        const subtotal = areaEnM2 * precio;

        document.getElementById('subtotal_terreno').value = subtotal.toFixed(2);

        calcularTotal();
    }


    // 🏗️ CONSTRUCCIÓN
    function calcularConstruccion() {
        const area = parseFloat(document.querySelector('[name="area_construccion"]').value) || 0;
        const precio = parseFloat(document.querySelector('[name="precio_construccion"]').value) || 0;

        const subtotal = area * precio;

        document.querySelector('[name="subtotal_construccion"]').value = subtotal.toFixed(2);

        calcularTotal();
    }

    // 💰 TOTAL GENERAL
    function calcularTotal() {

        const terreno = parseFloat(document.getElementById('subtotal_terreno').value) || 0;
        const construccion = parseFloat(document.querySelector('[name="subtotal_construccion"]').value) || 0;

        const total = terreno + construccion;

        document.getElementById('totalGeneral').innerText = total.toFixed(2);
        document.getElementById('valor_total').value = total.toFixed(2);

        calcularDepreciacion();
    }

    // 📉 DEPRECIACIÓN
    function calcularDepreciacion() {
        const totalConstruccion = parseFloat(document.querySelector('[name="subtotal_construccion"]').value) || 0;
        const vida = parseFloat(document.querySelector('[name="vida_util"]').value) || 0;

        const dep = vida > 0 ? totalConstruccion / vida : 0;

        document.querySelector('[name="depreciacion"]').value = dep.toFixed(2);
    }

    
</script>

@if($edit)

<script>
document.addEventListener('DOMContentLoaded', function(){

    abrirModal(
        'modalAvaluo',
        '/inversiones/{{ $inversion_id }}/avaluos/{{ $edit }}/edit'
    );

});
</script>

@endif