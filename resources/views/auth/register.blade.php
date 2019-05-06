@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <form method="POST" action="{{ route('register') }}">
                    <div class="card-body">
                        <h1 class="h6">Inscription</h1>

                        @csrf

                        {!! BootForm::text('name', 'Pseudo*') !!}
                        {!! BootForm::text('email', 'Adresse email*') !!}
                        {!! BootForm::password('password', 'Mot de passe*') !!}
                        {!! GoogleReCaptchaV3::renderField('register_id','register_action') !!}
                    </div>

                    <div class="card-footer bg-light">
                        <div class="text-center mb-3">
                            <small>En vous inscrivant et en utilisant nos services, vous déclarez avoir lu et acceptez les <a href="{{ route('terms') }}">Conditions générales d'utilisation</a>.</small>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Inscription</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
