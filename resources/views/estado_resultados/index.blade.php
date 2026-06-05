@extends('layouts.app')

@section('content')

<h2 style="margin-left:15px;">
    📊 Estado de Resultados
</h2>

<div style="margin-left:15px; margin-bottom:10px;">

    <a href="/inversiones"
       class="btn-secondary">
        ← Volver a Inversiones
    </a>

<button
    type="button"
    class="btn-new"
    onclick="abrirModalGenerar()">

    ⚙️ Generar Estado

</button>
</div>

<div class="container custom-container">

@foreach($estados as $estado)

<div class="inversion-card">

    <div class="inversion-title">

        Año {{ $estado->anio }}

    </div>

    @if($estados->count())

<div style="
    margin:15px;
    padding:15px;
    background:#f8fafc;
    border-radius:10px;
">

    <strong>
        Última Utilidad Neta:
    </strong>

    $ {{ number_format($estados->first()->utilidad_neta,2) }}

</div>

@endif

<div class="inversion-info">

    💰 Ingresos:
    $ {{ number_format($estado->ingresos,2) }}
    <br>

    📉 Costos:
    $ {{ number_format($estado->costos,2) }}
    <br>

    📦 Otros Gastos:
    $ {{ number_format($estado->otros_gastos,2) }}
    <br>

    📊 NOI:
    $ {{ number_format($estado->noi,2) }}
    <br>

    📉 Depreciación:
    $ {{ number_format($estado->depreciacion,2) }}
    <br>

    📈 EBIT:
    $ {{ number_format($estado->ebit,2) }}
    <br>

    💳 Gasto Financiero:
    $ {{ number_format($estado->gasto_financiero,2) }}
    <br>

    🏦 EBT:
    $ {{ number_format($estado->ebt,2) }}
    <br>

    💸 Impuestos:
    $ {{ number_format($estado->impuestos,2) }}
    <br><br>

    <strong>
        🏆 Utilidad Neta:
        $ {{ number_format($estado->utilidad_neta,2) }}
    </strong>

</div>

    <div class="actions">

        <a href="/inversiones/{{ $inversion_id }}/estado-resultados/{{ $estado->id }}/edit">
            ✏️ Editar
        </a>

        <form method="POST"
              action="/inversiones/{{ $inversion_id }}/estado-resultados/{{ $estado->id }}"
              style="display:inline;">

            @csrf
            @method('DELETE')

            <button type="submit">
                🗑️ Eliminar
            </button>

        </form>

    </div>

</div>

@endforeach

</div>


<div id="modalGenerar"
     style="
        display:none;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:rgba(0,0,0,.5);
        z-index:9999;
     ">

    <div style="
        background:white;
        width:500px;
        max-width:90%;
        margin:100px auto;
        padding:20px;
        border-radius:10px;
    ">

        <h3>
            📊 Generar Estado de Resultados
        </h3>

        <form method="POST"
              action="/inversiones/{{ $inversion_id }}/estado-resultados/generar">

            @csrf

            <div class="form-group">

                <label>Año</label>

                <input
                    type="number"
                    name="anio"
                    class="form-control"
                    value="{{ date('Y') }}"
                    required>

            </div>

            <div class="form-group">

                <label>Otros Gastos</label>

                <input
                    type="number"
                    step="0.01"
                    name="otros_gastos"
                    class="form-control"
                    value="0">

            </div>

            <div class="form-group">

                <label>Gasto Financiero</label>

                <input
                    type="number"
                    step="0.01"
                    name="gasto_financiero"
                    class="form-control"
                    value="0">

            </div>

            <div style="
                display:flex;
                justify-content:flex-end;
                gap:10px;
                margin-top:20px;
            ">

                <button
                    type="button"
                    class="btn-secondary"
                    onclick="cerrarModalGenerar()">

                    Cancelar

                </button>

                <button
                    type="submit"
                    class="btn-primary-custom">

                    ⚙️ Generar

                </button>

            </div>

        </form>

    </div>

</div>

<script>

function abrirModalGenerar()
{
    document.getElementById(
        'modalGenerar'
    ).style.display = 'block';
}

function cerrarModalGenerar()
{
    document.getElementById(
        'modalGenerar'
    ).style.display = 'none';
}

</script>
@endsection