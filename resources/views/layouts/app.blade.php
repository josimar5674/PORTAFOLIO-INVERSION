<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Portafolio Inversión</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<!-- MODAL ELIMINAR -->

<div id="deleteModal" class="modal-overlay">

    <div class="modal-box">

        <div class="modal-title">
            ⚠️ Confirmar eliminación
        </div>

        <div class="modal-text">
            Esta acción no se puede deshacer.
        </div>

        <div class="modal-actions">

            <button type="button"
                    class="btn-secondary"
                    onclick="cerrarModal()">

                Cancelar

            </button>

            <button type="button"
                    class="btn-danger"
                    id="confirmDeleteBtn">

                Eliminar

            </button>

        </div>

    </div>

</div>

<body>

<!-- HEADER -->
<header class="topbar">

    <!-- IZQUIERDA -->
    <div class="topbar-left">

        <a href="/" class="logo">
            💼 Portafolio
        </a>

        <nav class="menu">

            <a href="/inversiones">
                Inversiones
            </a>

            <a href="/clientes">
                Clientes
         @if(Auth::user()->role == 'admin')


    <a href="/entidades">
        Entidades
    </a>


@endif

            @auth

                @if(auth()->user()->role === 'admin')

                    <a href="/usuarios">
                        Usuarios
                    </a>

                @endif

            @endauth

        </nav>

    </div>

    <!-- DERECHA -->
    <div class="topbar-right">

        @auth

            <div class="user-box">

                <div class="user-info">

                    <div class="user-name">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="user-role">
                        {{ strtoupper(auth()->user()->role) }}
                    </div>

                </div>

                <a href="/profile"
                   class="profile-btn">

                    ⚙️ Mi Perfil

                </a>

                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                            class="logout-btn">

                        Salir

                    </button>

                </form>

            </div>

        @endauth

    </div>

</header>

<!-- CONTENIDO -->
<main class="main-content">

    @yield('content')

</main>

</body>

</html>


<script>

let deleteForm = null;

function confirmarEliminacion(form) {

    deleteForm = form;

    document
        .getElementById('deleteModal')
        .classList.add('show');

}

function cerrarModal() {

    document
        .getElementById('deleteModal')
        .classList.remove('show');

}

document
    .getElementById('confirmDeleteBtn')
    .addEventListener('click', function () {

        if(deleteForm){

            deleteForm.submit();

        }

    });

</script>