@extends('layouts.app')

@section('content')

<style>
.card-info{

    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:15px;
    padding:10px;
    margin-bottom:10px;

    background:var(--surface-2);
    border:1px solid var(--border);
    border-radius:8px;

}
    
</style>

<div class="form-card" style="width:100%; max-width:100%;">


    <div class="form-title">
        📊 Nuevo Estado de Resultado
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