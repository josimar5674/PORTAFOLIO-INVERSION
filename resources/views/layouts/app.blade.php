<!DOCTYPE html>
<html>
<head>

<style>

    footer {
    background: red;
}
</style>
    <title>Portafolio Inversión</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="d-flex flex-column" style="min-height: 100vh;">

<nav class="navbar navbar-default">
    <div class="container-fluid">

        <div class="navbar-header">

       
            <a class="navbar-brand" href="/">
                 <i class="fa-solid fa-suitcase"></i> Portafolio Inversión
            </a>
        </div>

        <ul class="nav navbar-nav">
            <li><a href="/clientes">Clientes</a></li>
            <li><a href="/inversiones">Inversiones</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li><a href="#">👤 Usuario</a></li>
            <li><a href="#">Cerrar sesión</a></li>
        </ul>

    </div>
</nav>



    @yield('content')
<!-- FOOTER -->
<footer class="text-center" style="
    
    bottom: 0;
    left: 0;
    width: 100%;
   
    height: 70px;

    padding: 15px;
    background: #f5f5f5;
    border-top: 1px solid #ddd;
">
    <p>© {{ date('Y') }} Portafolio de Inversión</p>
      
</footer>


</body>


</html>