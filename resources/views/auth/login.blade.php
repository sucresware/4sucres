@extends('layouts.app')

@section('title')
    Connexion
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <form method="POST" action="{{ route('login') }}" id="login">
                    <div class="card-header">
                        Connexion
                    </div>
                    <div class="card-body">
                        @csrf

                        @include('components.form.input', [
                            'type' => 'email',
                            'name' => 'email',
                            'label' => 'Adresse email',
                            'required' => true,
                        ])

                        @include('components.form.input', [
                            'type' => 'password',
                            'name' => 'password',
                            'label' => 'Mot de passe',
                            'required' => true,
                        ])

                        @include('components.form.checkbox', [
                            'name' => 'remember',
                            'label' => 'Se souvenir de moi',
                            'value' => 1
                        ])

                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger">
                                {{ $errors->first('g-recaptcha-response') }}
                            </span>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="float-left">
                            <a href="{{ route('password.request') }}">Mot de passe oublié</a>
                        </div>

                        <div class="text-right">
                            {!! NoCaptcha::displaySubmit('login', 'Connexion', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
