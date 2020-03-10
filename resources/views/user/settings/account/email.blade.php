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
            <form method="POST" action="{{ route('user.settings.account.email', []) }}" id="settings">
                @method('put')
                @csrf

                <div class="card mb-3">
                    <div class="card-header">
                        Modification de l'adresse e-mail
                    </div>
                    <div class="card-body">
                        @include('components.form.input', [
                            'type' => 'email',
                            'name' => 'email',
                            'label' => 'Adresse e-mail',
                            'value' => $user->email,
                            'required' => true,
                        ])
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection