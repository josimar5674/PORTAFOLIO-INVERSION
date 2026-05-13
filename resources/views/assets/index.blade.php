@extends('layouts.app')

@section('content')

<h2 style="margin-left:15px;">🏢 Activos</h2>

<h4 style="margin-left:15px; color:#555;">
    Total activos: {{ count($assets) }}
</h4>

@if(session('success'))
    <div class="alert alert-success" style="margin-left:15px;">
        {{ session('success') }}
    </div>
@endif

<div style="margin-left:15px;">
    <a href="/inversiones/{{ $investment_id }}/assets/create" class="btn-new">
        + Nuevo Activo
    </a>
</div>

<div style="margin-left:15px; margin-bottom:10px;">
    <a href="/inversiones" class="btn-secondary">← Volver a Inversiones</a>
</div>

<div class="card-grid">

    @foreach($assets as $asset)

        <div class="card">

            <div class="card-title">
                {{ $asset->name }}
            </div>

            <div class="card-info">

                📦 Tipo:
                {{ $asset->type }}

                <br><br>

                🏢 Nivel:
                {{ $asset->level_number }}

            </div>

            <div class="divider"></div>

            <div class="card-actions">

                <a href="/inversiones/{{ $investment_id }}/assets/{{ $asset->id }}/edit">

                    ✏️ Editar

                </a>

                <form action="/inversiones/{{ $investment_id }}/assets/{{ $asset->id }}"
                      method="POST"
                      style="display:inline;"
                      onsubmit="event.preventDefault(); confirmarEliminacion(this)">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn-danger">

                        🗑️ Eliminar

                    </button>

                </form>

            </div>

        </div>

    @endforeach

</div>

@endsection