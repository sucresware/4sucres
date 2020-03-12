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
            <form method="POST" action="{{ route('user.settings.account.password', []) }}" id="settings">
                @method('put')
                @csrf

                <div class="card mb-3">
                    <div class="card-header">
                        Modification du mot de passe
                    </div>
                    <div class="card-body">
                        @include('components.form.input', [
                            'type' => 'password',
                            'name' => 'password',
                            'label' => 'Mot de passe actuel',
                            'required' => true,
                        ])

                        @include('components.form.input', [
                            'type' => 'password',
                            'name' => 'new_password',
                            'label' => 'Nouveau mot de passe',
                            'required' => true,
                        ])

                        @include('components.form.input', [
                            'type' => 'password',
                            'name' => 'new_password_confirmation',
                            'label' => 'Nouveau mot de passe (confirmation)',
                            'required' => true,
                        ])
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Enregistrer</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
