@extends('layouts.app')

@section('title')
    500
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="text-center text-muted">
                <img src="{{ url('svg/sucre_angry.svg') }}" class="img-fluid mb-3" width="100px">
                <h1>Erreur 500</h1>
                <p>Le développeur est déjà au courant, alors calmez-vous et faites comme si vous n'avez rien vu !</p>
            </div>
        </div>
    </div>
</div>
@endsection