


@extends('layouts.app')

@section('content')

<h2>
    📋 Bitácoras
</h2>

   <div style="margin-bottom:15px;">
        <a href="/inversiones/{{ $inversion->id }}"
           class="btn-secondary" cursor:pointer >   
            ← Volver
        </a>
    </div>

@include('components.notes',[
    'modelo' => $inversion,
    'modelClass' => 'App\Models\Inversion'
])

<hr>

@include('components.documents',[
    'modelo' => $inversion,
    'modelClass' => 'App\Models\Inversion'
])

<hr>

@include('components.alerts',[
    'modelo' => $inversion,
    'referencia' => 'clave',
    'modelClass' => 'App\Models\Inversion'
])

@endsection