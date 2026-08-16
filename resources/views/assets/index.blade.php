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

                    @if(str_starts_with($asset->asset_code, 'DUP-'))

                    <small style="
            display:inline-block;
            margin-top:4px;
            padding:3px 7px;
            border-radius:6px;
            background:#fef3c7;
            color:#92400e;
            font-size:11px;
            font-weight:600;
        ">

                        📑 {{ $asset->asset_code }}

                    </small>

                    @else

                    <small>

                        {{ $asset->asset_code }}

                    </small>

                    @endif

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

                    <button
                        type="button"
                        class="btn-secondary"
                        title="Duplicar activo"
                        style="display:inline;     cursor: pointer;"

                        onclick="abrirModalDuplicar({{ $asset->id }}, '{{ addslashes($asset->name) }}')">

                        ▸▹▷

                    </button>

                    <form
                        action="/inversiones/{{ $inversion->id }}/assets/{{ $asset->id }}"
                        method="POST"
                        style="display:inline;"
                        onsubmit="event.preventDefault(); confirmarEliminacion(this)">

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
        .addEventListener('keyup', function() {

            let filtro = this.value.toLowerCase();

            document.querySelectorAll('#tablaActivos tr')
                .forEach(function(fila) {

                    fila.style.display =
                        fila.innerText.toLowerCase().includes(filtro) ?
                        '' :
                        'none';

                });

        });

    function abrirModalDuplicar(assetId, assetName) {
        const modal =
            document.getElementById('modalDuplicar');

        const form =
            document.getElementById('formDuplicar');

        const nombre =
            document.getElementById('nombreActivoDuplicar');

        form.action =
            `/inversiones/{{ $inversion->id }}/assets/${assetId}/duplicate`;

        nombre.innerText = assetName;

        modal.style.display = 'flex';
    }


    function cerrarModalDuplicar() {
        document.getElementById(
            'modalDuplicar'
        ).style.display = 'none';
    }


    document
        .getElementById('modalDuplicar')
        .addEventListener('click', function(e) {

            if (e.target === this) {

                cerrarModalDuplicar();

            }

        });


    document.addEventListener('keydown', function(e) {

        if (e.key === 'Escape') {

            cerrarModalDuplicar();

        }

    });
</script>

<!-- ===================================== -->
<!-- MODAL DUPLICAR ACTIVO -->
<!-- ===================================== -->

<div
    id="modalDuplicar"
    style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.5);
        z-index:9999;
        align-items:center;
        justify-content:center;
    ">

    <div
        style="
            width:450px;
            max-width:90%;
            background:var(--surface);
            color:var(--text);
            border:1px solid var(--border);
            border-radius:12px;
            padding:25px;
            box-shadow:var(--shadow);
        ">

        <h3 style="
            margin-top:0;
            color:var(--text);
        ">

            📑 Duplicar activo

        </h3>

        <p style="
            color:var(--text-secondary);
        ">

            Activo:

            <strong id="nombreActivoDuplicar"></strong>

        </p>

        <form
            id="formDuplicar"
            method="POST">

            @csrf

            <div class="form-group">

                <label>
                    Cantidad de copias
                </label>

                <input
                    type="number"
                    name="quantity"
                    class="form-control"
                    value="1"
                    min="1"
                    max="500"
                    required>

            </div>

            <div
                style="
                    margin-top:15px;
                    padding:12px;
                    border-radius:8px;
                    background:var(--surface-2);
                    border:1px solid var(--border);
                    color:var(--text-secondary);
                    font-size:13px;
                ">

                ℹ️ Cada copia recibirá un identificador
                temporal como:

                <strong>
                    DUP-15-A7K92P
                </strong>

                <br><br>

                El número de serie quedará vacío para que
                puedas asignarlo posteriormente.

            </div>

            <div
                style="
                    display:flex;
                    justify-content:flex-end;
                    gap:10px;
                    margin-top:20px;
                ">

                <button
                    type="button"
                    class="btn-secondary"
                    onclick="cerrarModalDuplicar()">

                    Cancelar

                </button>

                <button
                    type="submit"
                    class="btn-primary-custom">

                    📑 Duplicar

                </button>

            </div>

        </form>

    </div>

</div>

@endsection