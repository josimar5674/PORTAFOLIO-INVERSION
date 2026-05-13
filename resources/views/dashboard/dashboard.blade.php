@extends('layouts.app')

@section('content')

<div class="page-container">

    <h1 class="page-title">
        📊 Dashboard
    </h1>

</div>

<div class="dashboard-grid">

    <!-- CLIENTES -->
    <a href="/clientes" class="dashboard-card">

        <div class="dashboard-icon">
            👥
        </div>

        <div class="dashboard-title">
            Clientes
        </div>

        <div class="dashboard-description">
            Gestionar base de clientes
        </div>

        <div class="dashboard-metric">

            Total registrados:
            <strong>

                {{ $clientes }}

            </strong>

        </div>

    </a>

    <!-- INVERSIONES -->
    <a href="/inversiones" class="dashboard-card">

        <div class="dashboard-icon">
            💼
        </div>

        <div class="dashboard-title">
            Inversiones
        </div>

        <div class="dashboard-description">
            Gestionar portafolio de inversión
        </div>

        <div class="dashboard-metric">

            💰 Financiero:
            <strong>

                $ {{ number_format($totalFinanciero, 2) }}

            </strong>

        </div>

        <div class="dashboard-metric">

            ⚙️ Operativo:
            <strong>

                $ {{ number_format($totalOperativo, 2) }}

            </strong>

        </div>

        <div class="dashboard-metric">

            📈 Comercial:
            <strong>

                $ {{ number_format($totalComercial, 2) }}

            </strong>

        </div>

    </a>

    <!-- ENTIDADES -->
    <a href="/entidades" class="dashboard-card">

        <div class="dashboard-icon">
            🏢
        </div>

        <div class="dashboard-title">
            Entidades
        </div>

        <div class="dashboard-description">
            Gestionar entidades relacionadas
        </div>

        <div class="dashboard-metric">

            Total entidades:
            <strong>

                {{ $entidades }}

            </strong>

        </div>

    </a>

</div>

@endsection