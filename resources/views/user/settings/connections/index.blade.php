@extends('layouts.app')

@section('title')
    Paramètres
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-3 col-xl-2 mb-3">
            @include('user.settings._navigation')
        </div>
        <div class="col-lg-7 col-xl-8">
            <div class="card mb-3">
                <div class="card-header">
                    Connexions
                </div>
                <div class="card-body">
                    <p>Connectez vos comptes à 4sucres pour pouvoir accéder à des intégrations spéciales !</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection