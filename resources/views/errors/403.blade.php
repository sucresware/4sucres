@extends('layouts.app')

@section('title')
    403
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="text-center text-muted">
                <img src="{{ url('img/errors/403.png') }}" class="img-fluid mb-3" width="350px">
                <h1>Erreur 403</h1>
                <p>T'as rien à faire la, casse-toi d'ici.</p>
            </div>
        </div>
    </div>
</div>
@endsection