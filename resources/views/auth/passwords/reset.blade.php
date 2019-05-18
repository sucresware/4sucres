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
                        {!! BootForm::hidden('token', $token) !!}
                        {!! BootForm::password('password', 'Nouveau mot de passe*') !!}
                        {!! BootForm::password('password_confirmation', 'Nouveau mot de passe (confirmation)*') !!}

                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger">
                                {{ $errors->first('g-recaptcha-response') }}
                            </span>
                        @endif
                    </div>
                    <div class="card-footer bg-light">
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
