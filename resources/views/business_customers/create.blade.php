@extends('layouts.app')

@section('content')

<div class="form-card">

    <div class="form-title">

        ➕ Nuevo Cliente

        

    </div>



    <div style="margin-bottom:15px;">

    <a href="/business-customers"
       class="btn-secondary">

        ← Volver a Clientes

    </a>

</div>
    
    

    <form method="POST"
          action="/business-customers">

        @csrf

        <div class="form-group">

            <label>Nombre</label>

            <input
                type="text"
                name="nombre"
                class="form-control">

        </div>

        <div class="form-group">

            <label>Identificador Tributario</label>

            <input
                type="text"
                name="identificador_tributario"
                class="form-control">

        </div>

        <div class="form-group">

            <label>Correo</label>

            <input
                type="email"
                name="email"
                class="form-control">

        </div>

        <div class="form-group">

            <label>Teléfono</label>

            <input
                type="text"
                name="telefono"
                class="form-control">

        </div>

        <hr>


        <div style="margin-top:20px;">

            <button
                class="btn-primary-custom">

                💾 Guardar

            </button>

        </div>

    </form>

</div>



@endsection