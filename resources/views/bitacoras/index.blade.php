


@extends('layouts.app')

@section('content')

<h2>
    📋 Bitácoras
</h2>

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
    'modelClass' => 'App\Models\Inversion'
])

@endsection