@extends('layouts.app')

@section('title')
    500
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="text-center text-muted">
                <img src="{{ url('img/errors/500.png') }}" class="img-fluid mb-3" width="500px">
                <h1>Erreur 500</h1>
                <p>Le développeur est déjà au courant, alors calmez-vous et allez faire un tour sur VocaBank !</p>
            </div>
        </div>
    </div>
</div>
@endsection