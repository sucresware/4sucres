@extends('layouts.app')

@section('title')
    410
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="text-center text-muted">
                <img src="{{ url('img/errors/410.png') }}" class="img-fluid mb-3" width="480px">
                <h1>Erreur 410</h1>
                <p>La page que tu cherches a été supprimée, pas de BOL !</p>
            </div>
        </div>
    </div>
</div>
@endsection