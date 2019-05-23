@extends('layouts.app')

@section('title')
    404
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="text-center text-muted">
                <img src="{{ url('img/errors/404.png') }}" class="img-fluid mb-3" width="300px">
                <h1>Erreur 404</h1>
                <p>La page que tu cherches est introuvable, pas de CHANCE !</p>
            </div>
        </div>
    </div>
</div>
@endsection