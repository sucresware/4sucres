@extends('layouts.app')

@section('title')
    Mot de passe oublié
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <form method="POST" action="{{ route('password.email') }}" id="request_reset">
                    <div class="card-body">
                        <h1 class="h6">Mot de passe oublié</h1>

                        @csrf
                        {!! BootForm::text('email', 'Adresse email*') !!}

                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger">
                                {{ $errors->first('g-recaptcha-response') }}
                            </span>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            {!! NoCaptcha::displaySubmit('request_reset', 'Aide-moi à récupérer mon compte !', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
