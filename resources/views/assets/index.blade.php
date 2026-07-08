@extends('layouts.app')

@section('content')

@php

$totalActivos = $assets->count();

$totalCategorias = $assets->pluck('category')
    ->filter()
    ->unique()
    ->count();

$valorTotal = $assets->sum('purchase_value');

@endphp

<div class="investment-header">

    <div>

        <h1>
            📦 Activos Mobiliarios
        </h1>

        <small>

            {{ $inversion->nombre }}

            ·

            {{ $totalActivos }} activos registrados

        </small>

    </div>

    <div>

        <a href="/inversiones/{{ $inversion->id }}"
            class="btn-secondary">

            ← Volver

        </a>

        <a href="/inversiones/{{ $inversion->id }}/assets/create"
            class="btn-primary-custom">

            + Nuevo Activo

        </a>

    </div>

</div>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="summary-grid">

    <div class="summary-card">

        📦 Activos

        <strong>

            {{ $totalActivos }}

        </strong>

    </div>

    <div class="summary-card">

        🏷️ Categorías

        <strong>

            {{ $totalCategorias }}

        </strong>

    </div>

    <div class="summary-card">

        💰 Valor Total

        <strong>

            $ {{ number_format($valorTotal,2) }}

        </strong>

    </div>

</div>

<div style="margin:20px 0;">

    <input
        type="text"
        id="buscadorActivos"
        class="form-control"
        placeholder="🔍 Buscar por nombre, categoría, marca, modelo o código...">

</div>

<div style="overflow-x:auto;">

<table class="table-dashboard">

    <thead>

        <tr>

            <th>Activo</th>

            <th>Categoría</th>

            <th>Marca</th>

            <th>Modelo</th>

            <th>Valor</th>

            <th>Estado</th>

            <th>Acciones</th>

        </tr>

    </thead>

    <tbody id="tablaActivos">

        @foreach($assets as $asset)

        <tr>

            <td>

                <strong>

                    {{ $asset->name }}

                </strong>

                @if($asset->asset_code)

                    <br>

                    <small>

                        {{ $asset->asset_code }}

                    </small>

                @endif

            </td>

            <td>

                {{ $asset->category }}

            </td>

            <td>

                {{ $asset->brand }}

            </td>

            <td>

                {{ $asset->model }}

            </td>

            <td>

                $ {{ number_format($asset->purchase_value,2) }}

            </td>

            <td>

                @if($asset->status)

                    <span style="color:green;font-weight:bold;">

                        Activo

                    </span>

                @else

                    <span style="color:red;font-weight:bold;">

                        Inactivo

                    </span>

                @endif

            </td>

            <td>

                <a href="/inversiones/{{ $inversion->id }}/assets/{{ $asset->id }}/edit"
                    class="btn-secondary">

                    Ver

                </a>

                <form
                    action="/inversiones/{{ $inversion->id }}/assets/{{ $asset->id }}"
                    method="POST"
                    style="display:inline;"
                    onsubmit="event.preventDefault(); confirmarEliminacion(this)">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
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

<script>

document.getElementById('buscadorActivos')
.addEventListener('keyup', function(){

    let filtro = this.value.toLowerCase();

    document.querySelectorAll('#tablaActivos tr')
    .forEach(function(fila){

        fila.style.display =
            fila.innerText.toLowerCase().includes(filtro)
            ? ''
            : 'none';

    });

});

</script>

@endsection