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

@include('components.documents',[
    'modelo' => $cliente,
    'modelClass' => 'App\Models\BusinessCustomer'
])

</div>
@endsection