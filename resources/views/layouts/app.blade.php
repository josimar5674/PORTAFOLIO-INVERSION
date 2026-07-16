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

        @include('layouts.css')
        @include('layouts.theme-components')

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

                 @if(Auth::user()->role == 'admin')

            <a href="/clientes">
                Personas
            </a>
            @endif


            <a href="/business-customers">
                Clientes
            </a>
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

    <button id="themeToggle" class="theme-btn" title="Cambiar tema">
        🌙
    </button>

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

    // ===============================
// TEMA CLARO / OSCURO
// ===============================

const themeBtn = document.getElementById('themeToggle');

const savedTheme = localStorage.getItem('theme') || 'light';

document.documentElement.setAttribute('data-theme', savedTheme);

themeBtn.innerHTML = savedTheme === 'dark'
    ? '☀️'
    : '🌙';

themeBtn.addEventListener('click', () => {

    const currentTheme = document.documentElement.getAttribute('data-theme');

    const newTheme = currentTheme === 'dark'
        ? 'light'
        : 'dark';

    document.documentElement.setAttribute('data-theme', newTheme);

    localStorage.setItem('theme', newTheme);

    themeBtn.innerHTML = newTheme === 'dark'
        ? '☀️'
        : '🌙';

});
function abrirModal(id, url){

    fetch(url)
        .then(response => response.text())
        .then(html => {

            document.getElementById('contenedorFormularioAvaluo').innerHTML = html;

            document
                .getElementById(id)
                .classList
                .add('show');

        });

}

function cerrarModal(id){

    document
        .getElementById(id)
        .classList
        .remove('show');

}

document.addEventListener('keydown',function(e){

    if(e.key==="Escape"){

        document
            .querySelectorAll('.modal-overlay-custom.show')
            .forEach(function(modal){

                modal.classList.remove('show');

            });

    }

});

</script>