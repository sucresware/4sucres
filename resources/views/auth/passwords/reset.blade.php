@extends('layouts.app')

@section('title')
    Redéfinir mon mot de passe
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <form method="POST" action="{{ route('password.update', $token) }}" id="reset">
                    <div class="card-body">
                        <h1 class="h6">Redéfinir mon mot de passe</h1>

                        @csrf

                        <input type="hidden" value="{{ $token }}" name="token">

                        @include('components.form.input', [
                            'type' => 'password',
                            'name' => 'password',
                            'label' => 'Nouveau mot de passe',
                            'required' => true,
                        ])

                        @include('components.form.input', [
                            'type' => 'password',
                            'name' => 'password_confirmation',
                            'label' => 'Nouveau mot de passe (confirmation)',
                            'required' => true,
                        ])

                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger">
                                {{ $errors->first('g-recaptcha-response') }}
                            </span>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            {!! NoCaptcha::displaySubmit('reset', 'C\'est bon, je vais m\'en souvenir', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
