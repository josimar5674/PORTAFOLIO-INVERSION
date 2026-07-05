@extends('layouts.app')

@section('content')

<div class="form-card">

    <div class="form-title">

        ➕ Editar Cliente 

    </div>


    <div style="margin-bottom:15px;">

    <a href="/business-customers"
       class="btn-secondary">

        ← Volver a Clientes

    </a>

</div>  
<form method="POST" action="/business-customers/{{ $cliente->id }}">

    @csrf
    @method('PUT')

    <!-- Todos los campos -->

    <div class="form-group">
        <label>Nombre</label>
        <input
            type="text"
            name="nombre"
            class="form-control"
            value="{{ old('nombre', $cliente->nombre) }}">
    </div>

    <div class="form-group">
        <label>Identificador Tributario</label>
        <input
            type="text"
            name="identificador_tributario"
            class="form-control"
            value="{{ old('identificador_tributario', $cliente->identificador_tributario) }}">
    </div>

    <div class="form-group">
        <label>Correo</label>
        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ old('email', $cliente->email) }}">
    </div>

    <div class="form-group">
        <label>Teléfono</label>
        <input
            type="text"
            name="telefono"
            class="form-control"
            value="{{ old('telefono', $cliente->telefono) }}">
    </div>

    <div style="margin-top:20px;">

        <button
            type="submit"
            class="btn-primary-custom">

            💾 Actualizar

        </button>

    </div>

</form>


<hr>

@include('components.notes',[
    'modelo' => $cliente,
    'modelClass' => 'App\Models\BusinessCustomer'
])

<hr>
<hr>

<div class="card-seccion">

    <h3>📄 Documentos</h3>

    <form
        method="POST"
        action="/documentos"
        enctype="multipart/form-data">

        @csrf

        <input
            type="hidden"
            name="documentable_type"
            value="App\Models\BusinessCustomer">

        <input
            type="hidden"
            name="documentable_id"
            value="{{ $cliente->id }}">

        <div style="
            display:flex;
            gap:10px;
            margin-bottom:15px;
        ">

            <input
                type="text"
                name="nombre"
                class="form-control"
                placeholder="Nombre del documento..."
                required>

            <input
                type="file"
                name="archivo"
                class="form-control"
                required>

            <button
                type="submit"
                class="btn-primary-custom">

                📤

            </button>

        </div>

    </form>

    @forelse($cliente->documentos()->latest()->get() as $documento)

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:15px;
            padding:10px;
            margin-bottom:10px;
            border:1px solid #e5e7eb;
            border-radius:8px;
            background:#f9fafb;
        ">

            <div style="flex:1;">

                <div>

                    📄 <strong>{{ $documento->nombre }}</strong>

                </div>

                <small style="color:#6b7280;">

                    {{ $documento->created_at->format('d/m/Y H:i') }}

                </small>

            </div>

            <div style="
                display:flex;
                gap:10px;
                align-items:center;
            ">

                <a
                    href="{{ asset('storage/'.$documento->archivo) }}"
                    target="_blank"
                    class="btn-secondary">

                    Ver

                </a>

                <form
                    method="POST"
                    action="/documentos/{{ $documento->id }}">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        style="
                            border:none;
                            background:none;
                            color:#ef4444;
                            cursor:pointer;
                            font-size:16px;
                        ">

                        🗑️

                    </button>

                </form>

            </div>

        </div>

    @empty

        <div style="
            color:#6b7280;
            padding:10px;
        ">

            No hay documentos cargados.

        </div>

    @endforelse

</div>

</div>
@endsection