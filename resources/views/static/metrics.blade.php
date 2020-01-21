@extends('layouts.app')

@section('title')
    Statistiques
@endsection

@section('content')

<div class="container">
    <div class="card mb-3">
        <div class="card-header">
            Statistiques générales
        </div>
        <div class="card-body">
            <ul>
                @foreach ($metrics['overall'] as $name => $value)
                    <li><b>{{ $name }}</b> : {{ $value }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            Statistiques du mois
        </div>
        <div class="card-body">
            <ul>
                @foreach ($metrics['monthly'] as $name => $value)
                    <li><b>{{ $name }}</b> : {{ $value }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            Statistiques de la semaine
        </div>
        <div class="card-body">
            <ul>
                @foreach ($metrics['weekly'] as $name => $value)
                    <li><b>{{ $name }}</b> : {{ $value }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            Statistiques du jour
        </div>
        <div class="card-body">
            <ul>
                @foreach ($metrics['daily'] as $name => $value)
                    <li><b>{{ $name }}</b> : {{ $value }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection
