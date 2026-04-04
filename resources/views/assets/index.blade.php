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

<div class="container custom-container">

    <div class="row">

        @foreach($assets as $asset)

            <div class="col-md-6">
                <div class="asset-card">

                    <div class="asset-title">
                        {{ $asset->name }}
                    </div>

                    <div class="asset-info">
                        📦 Tipo: {{ $asset->type }}<br>
                        🏢 Nivel: {{ $asset->level_number }}
                    </div>

                    <div class="divider"></div>

                    <div class="asset-actions">

                        <a href="/inversiones/{{ $investment_id }}/assets/{{ $asset->id }}/edit">
                            ✏️ Editar
                        </a>

                        <form action="/inversiones/{{ $investment_id }}/assets/{{ $asset->id }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">🗑️ Eliminar</button>
                        </form>

                    </div>

                </div>
            </div>

        @endforeach

    </div>

</div>

@endsection