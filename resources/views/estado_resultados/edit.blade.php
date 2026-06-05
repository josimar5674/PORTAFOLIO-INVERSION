@extends('layouts.app')

@section('content')

<div class="form-card">

    <div class="form-title">
        ✏️ Editar Estado de Resultados
    </div>

    <form method="POST"
          action="/inversiones/{{ $estado->inversion_id }}/estado-resultados/{{ $estado->id }}">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Año</label>
            <input type="number"
                   name="anio"
                   class="form-control"
                   value="{{ $estado->anio }}">
        </div>

        <div class="form-group">
            <label>Ingresos</label>
            <input type="number"
                   step="0.01"
                   name="ingresos"
                   class="form-control"
                   value="{{ $estado->ingresos }}">
        </div>

        <div class="form-group">
            <label>Costos</label>
            <input type="number"
                   step="0.01"
                   name="costos"
                   class="form-control"
                   value="{{ $estado->costos }}">
        </div>

        <div class="form-group">
            <label>Otros Gastos</label>
            <input type="number"
                   step="0.01"
                   name="otros_gastos"
                   class="form-control"
                   value="{{ $estado->otros_gastos }}">
        </div>

        <div class="form-group">
            <label>Gasto Financiero</label>
            <input type="number"
                   step="0.01"
                   name="gasto_financiero"
                   class="form-control"
                   value="{{ $estado->gasto_financiero }}">
        </div>

        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">
                💾 Actualizar
            </button>

            <a href="/inversiones/{{ $estado->inversion_id }}/estado-resultados"
               class="btn-secondary">
                ← Volver
            </a>
        </div>

    </form>

</div>

@endsection