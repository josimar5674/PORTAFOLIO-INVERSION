@extends('layouts.app')

@section('content')

<h2 style="margin-bottom:20px;">
    🔐 Cambiar Contraseña
</h2>

<div class="form-card">

    @if(session('status'))

        <div class="success-box">

            Contraseña actualizada correctamente.

        </div>

    @endif

    <form method="POST"
          action="{{ route('password.update') }}">

        @csrf
        @method('PUT')

        <!-- ACTUAL -->
        <div class="form-group">

            <label class="form-label">

                Contraseña Actual

            </label>

            <input type="password"
                   name="current_password"
                   class="form-control">

            @error('current_password')

                <small style="color:red;">
                    {{ $message }}
                </small>

            @enderror

        </div>

        <!-- NUEVA -->
        <div class="form-group">

            <label class="form-label">

                Nueva Contraseña

            </label>

            <input type="password"
                   name="password"
                   class="form-control">

            @error('password')

                <small style="color:red;">
                    {{ $message }}
                </small>

            @enderror

        </div>

        <!-- CONFIRMAR -->
        <div class="form-group">

            <label class="form-label">

                Confirmar Contraseña

            </label>

            <input type="password"
                   name="password_confirmation"
                   class="form-control">

        </div>

        <button type="submit"
                class="btn-primary-custom">

            💾 Actualizar Contraseña

        </button>

    </form>

</div>

@endsection