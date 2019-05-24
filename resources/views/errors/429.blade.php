@extends('layouts.app')

@section('title')
    429
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="text-center text-muted">
                <img src="{{ url('/img/errors/429.png') }}" class="img-fluid mb-3" width="300px">
                <h1>Erreur 429</h1>
                <p>Commence par cliquer plus lentement !</p>
            </div>
        </div>
    </div>
</div>
@endsection