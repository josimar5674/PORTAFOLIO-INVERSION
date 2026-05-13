@extends('layouts.app')

@section('content')

<div style="
    min-height:80vh;
    display:flex;
    justify-content:center;
    align-items:center;
">

    <div class="form-card" style="max-width:450px; width:100%;">

        <!-- LOGO -->
        <div style="text-align:center; margin-bottom:30px;">

            <div style="font-size:60px;">
                💼
            </div>

            <h1 style="
                margin:10px 0 5px;
                font-size:28px;
                font-weight:bold;
                color:#111827;
            ">
                Portafolio de Inversión
            </h1>

            <p style="color:#6b7280;">
                Inicia sesión para continuar
            </p>

        </div>

        <!-- ERRORES -->
        @if ($errors->any())

            <div class="error-box">

                <ul style="margin:0; padding-left:20px;">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <!-- FORM -->
        <form method="POST"
              action="{{ route('login') }}">

            @csrf

            <!-- EMAIL -->
            <div class="form-group">

                <label class="form-label">

                    Correo Electrónico

                </label>

                <input type="email"
                       name="email"
                       class="form-control"
                       required
                       autofocus>

            </div>

            <!-- PASSWORD -->
            <div class="form-group">

                <label class="form-label">

                    Contraseña

                </label>

                <input type="password"
                       name="password"
                       class="form-control"
                       required>

            </div>

            <!-- RECORDAR -->
            <div style="
                margin-bottom:20px;
                display:flex;
                align-items:center;
                gap:10px;
            ">

                <input type="checkbox"
                       name="remember">

                <label style="font-size:14px; color:#4b5563;">

                    Recordarme

                </label>

            </div>

            <!-- BOTON -->
            <button type="submit"
                    class="btn-primary-custom"
                    style="
                        width:100%;
                        padding:14px;
                        font-size:15px;
                    ">

                🔐 Iniciar Sesión

            </button>

        </form>

    </div>

</div>

@endsection