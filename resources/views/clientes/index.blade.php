@extends('layouts.app')



@section('content')

<h2 style="margin-left:15px;">👥 Personas</h2>
<h4 style="margin-left:15px; color:#555;">
    Total clientes: {{ count($clientes) }}
</h4>
@if(session('success'))
    <div class="alert alert-success" style="margin-left:15px;">
        {{ session('success') }}
    </div>
@endif

<div style="margin-left:15px;">
    <a href="/clientes/create" class="btn-new">
        + Nueva persona
    </a>
</div>

<div class="container custom-container">

    <div class="row">

        @foreach($clientes as $cliente)

            <div class="col-md-6">
                <div class="cliente-card">

                    <div class="cliente-title">
                        {{ $cliente->nombre }}
                    </div>

                    <div class="cliente-info">
                        🧾 Tipo: {{ $cliente->tipo }}
                    </div>

                    <div class="divider"></div>

                    <div class="cliente-actions">

                        <a href="/clientes/{{ $cliente->id }}/edit">
                            ✏️ Editar
                        </a>

                        <form action="/clientes/{{ $cliente->id }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">🗑️ Eliminar</button>
                        </form>

                    </div>

                </div>
                  <br>
            </div>

           

        @endforeach


       

    </div>

    

</div>

@endsection