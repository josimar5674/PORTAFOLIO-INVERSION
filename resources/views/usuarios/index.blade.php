@extends('layouts.app')

@section('content')

<div class="page-container">

    <h1 class="page-title">
        👤 Usuarios
    </h1>

    <a href="/usuarios/create"
       class="btn-new">

        + Nuevo Usuario

    </a>

</div>

@if(session('success'))

    <div class="success-box">

        {{ session('success') }}

    </div>

@endif

<div class="card-grid">

    @foreach($usuarios as $usuario)

        <div class="card">

            <!-- TITULO -->
            <div class="card-title">

                {{ $usuario->name }}

            </div>

            <!-- INFO -->
            <div class="card-info">

                📧 Email:
                {{ $usuario->email }}

                <br><br>

                🛡️ Rol:
                <strong>

                    {{ strtoupper($usuario->role) }}

                </strong>

                <br><br>

                📌 Estado:

                @if($usuario->estado)

                    <span style="
                        background:#dcfce7;
                        color:#166534;
                        padding:4px 10px;
                        border-radius:20px;
                        font-size:12px;
                        font-weight:600;
                    ">

                        ACTIVO

                    </span>

                @else

                    <span style="
                        background:#fee2e2;
                        color:#991b1b;
                        padding:4px 10px;
                        border-radius:20px;
                        font-size:12px;
                        font-weight:600;
                    ">

                        INACTIVO

                    </span>

                @endif

            </div>

            <div class="divider"></div>

            <!-- ACCIONES -->
            <div class="card-actions">

                <a href="/usuarios/{{ $usuario->id }}/edit">

                    ✏️ Editar Usuario

                </a>

            </div>

        </div>

    @endforeach

</div>

@endsection