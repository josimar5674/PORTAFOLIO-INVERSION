@extends('layouts.app')

@section('content')

<div class="form-card">

    <div class="form-title">
        📊 Nuevo Estado de Resultados
    </div>

    <form method="POST" action="/inversiones/{{ $inversion_id }}/estado-resultados">
        @csrf

        <div class="form-group">
            <label>Año</label>
            <input type="number"
                   name="anio"
                   class="form-control"
                   value="{{ old('anio', date('Y')) }}">
        </div>

        <div class="form-group">
            <label>Ingresos</label>
            <input type="number"
                   step="0.01"
                   name="ingresos"
                   class="form-control">
        </div>

        <div class="form-group">
            <label>Costos</label>
            <input type="number"
                   step="0.01"
                   name="costos"
                   class="form-control">
        </div>

        <div class="form-group">
            <label>Otros Gastos</label>
            <input type="number"
                   step="0.01"
                   name="otros_gastos"
                   class="form-control">
        </div>

        <div class="form-group">
            <label>Gasto Financiero</label>
            <input type="number"
                   step="0.01"
                   name="gasto_financiero"
                   class="form-control">
        </div>

        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">
                💾 Guardar
            </button>

            <a href="/inversiones/{{ $inversion_id }}/estado-resultados"
               class="btn-secondary">
                ← Volver
            </a>
        </div>

    </form>

</div>

@endsection