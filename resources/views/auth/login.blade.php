@extends('layouts.app')

@section('title')
    Connexion
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <form method="POST" action="{{ route('login') }}">
                    <div class="card-body">
                        <h1 class="h6">Connexion</h1>
                        @csrf
                        {!! GoogleReCaptchaV3::renderField('login_id', 'login_action') !!}

                        {!! BootForm::text('email', 'Adresse email*') !!}
                        {!! BootForm::password('password', 'Mot de passe*') !!}

                    </div>
                    <div class="card-footer bg-light">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Connexion</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
