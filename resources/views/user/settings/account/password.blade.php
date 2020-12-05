@extends('layouts.app')

@section('title')
    Paramètres
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="mb-3 col-lg-3 col-xl-2">
            @include('user.settings._navigation')
        </div>
        <div class="col-lg-7 col-xl-8">
            <form method="POST" action="{{ route('user.settings.account.password', []) }}" id="settings">
                @method('put')
                @csrf

                <div class="mb-3 card">
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

            <div class="mb-3 card">
                <div class="card-header">
                    Authentification forte (Google 2FA)
                </div>
                <div class="card-body">
                    <strong>Protège ton compte avec le 2FA !</strong> L’authentification à deux facteurs (2FA) est une fonction de sécurité qui aide à protéger ton compte 4sucres en plus de ton mot de passe. Un second mot de passe temporaire et unique (TOTP) te sera demandé à chaque connexion.<br>
                    <br>
                    Pour utiliser le 2FA, tu dois installer une application Google Autenticator compatible. Par exemple :<br>
                    <ul>
                        <li>Google Authenticator (<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=fr" target="_blank">Android</a>, <a href="https://apps.apple.com/fr/app/google-authenticator/id388497605" target="_blank">iOS)</li>
                        <li><a href="https://1password.com/" target="_blank">1Password (Android, iOS, Chrome, Windows, macOS)</a></li>
                        <li><a href="https://www.authy.com/" target="_blank">Authy (Android, iOS, Chrome, macOS)</a></li>
                        <li><a href="https://lastpass.com/auth/" target="_blank">LastPass Authenticator (Android, iOS, Windows, macOS)</a></li>
                    </ul>

                    @if ($google_2fa['enabled'])
                        <div class="text-center alert">
                            {!! $google_2fa['qr_image'] !!}

                            <p>
                                Configure le 2FA en scannant le code ci-dessus.<br>
                                Tu peux aussi directement utiliser le code : <strong>{{ $google_2fa['secret'] }}</strong><br>
                                <br>
                                <strong class="text-danger">Tu dois configurer ton application Google Authenticator maintenant avant de continuer, <span class="spoiler">sinon tu ne pourras plus te connecter <span class="spoiler">gros singe</span></span>.</strong><br>
                            </p>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    @if (!$google_2fa['enabled'])
                        <div class="text-right">
                            <a href="{{ route('user.settings.account.security.2fa.enable') }}" class="btn btn-primary"><i class="fas fa-lock"></i> Activer le 2FA</a>
                        </div>
                    @else
                        <div class="text-right">
                            <a href="{{ route('user.settings.account.security.2fa.disable') }}" class="btn btn-danger"><i class="fas fa-lock"></i> Désactiver le 2FA</a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
