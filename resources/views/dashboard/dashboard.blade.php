@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="text-center">Dashboard - Portafolio de Inversión</h2>
    <hr>

    <div class="row">


<div class="col-sm-4">
    <a href="/clientes" style="text-decoration:none;">
        <div class="panel panel-success text-center">
            <div class="panel-heading">
                <h4><i class="fa-solid fa-users"></i> Clientes</h4>
            </div>
            <div class="panel-body">
                <p>Gestionar base clientes</p>
            </div>
        </div>
    </a>
</div>


        <!-- INVERSIONES -->
  <div class="col-sm-4">
    <a href="/inversiones" style="text-decoration:none;">
        <div class="panel panel panel-primary text-center">
            <div class="panel-heading">
                <h4><i class="fa-solid fa-building-circle-arrow-right"></i> Inversiones</h4>
            </div>
            <div class="panel-body">
                <p>Gestionar portafolio</p>
            </div>
        </div>
    </a>
</div>

  <div class="col-sm-4">
    <a href="/entidades" style="text-decoration:none;">
        <div class="panel panel-warning text-center">
            <div class="panel-heading">
                <h4><i class="fa-solid fa-sitemap"></i> Entidades</h4>
            </div>
            <div class="panel-body">
                <p>Gestionar portafolio</p>
            </div>
        </div>
    </a>
</div>



</div>

@endsection