@extends('layouts.app')

@section('title')
    Inscription
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                {!! BootForm::horizontal([
                    'url' => route('register'),
                    'method' => 'post',
                    'left_column_class' => 'col-md-2',
                    'left_column_offset_class' => 'col-md-offset-2',
                    'right_column_class' => 'col-md-10',
                    'id' => 'register',
                ]) !!}
                    <div class="card-body">
                        <div class="text-center">
                            <h1>Formulaire d'admission</h1>
                            <img src="https://image.noelshack.com/fichiers/2018/49/1/1543859026-ne-tinquiete-pas-ca-va-bien-spasser-ne-tinquiete-pas-kekeh.png" class="img-fluid" width="60px">
                            <p>Ne t'inquiète pas ça va bien se passer, bien se passer ne t'inquiète pas.</p>
                        </div>

                        <hr>

                        @csrf

                        {!! BootForm::text('name', 'Pseudo*', old('name'), ['help_text' => "Tu peux définir un nom d'affichage différent plus tard !"]) !!}
                        {!! BootForm::text('email', 'Adresse email*', old('email'), ['help_text' => "Ton email ne sera jamais partagé ou affiché publiquement."]) !!}
                        {!! BootForm::password('password', 'Mot de passe*', ['help_text' => "6 caractères minimum, c'est important pour la sécurité."]) !!}
                        {!! BootForm::date('dob', 'Date de naissance*', old('dob'), ['help_text' => "On a pas le droit d'utiliser ça UNIQUEMENT qu'en cas de restrictions pour les messages NSFW."]) !!}

                        <div class="form-group row">
                            <label for="gender" class="col-form-label col-md-2">Sexe*</label>
                            <div class="col-md-10">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input name="gender" id="gender_M" type="radio" value="M" {{ old('gender') == "M" ? 'checked' : '' }} class="custom-control-input">
                                    <label for="gender_M" class="custom-control-label">Homme</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input name="gender" id="gender_F" type="radio" value="F" {{ old('gender') == "F" ? 'checked' : '' }} class="custom-control-input">
                                    <label for="gender_F" class="custom-control-label">Femme</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input name="gender" id="gender_O" type="radio" value="O" {{ old('gender') == "O" ? 'checked' : '' }} class="custom-control-input">
                                    <label for="gender_O" class="custom-control-label">Non-binaire</label>
                                </div>
                                <br>

                                @if ($errors->has('gender'))
                                    <small class="text-danger">{!! $errors->first('gender') !!}</small><br>
                                @endif

                                <span class="help-block">Il ne faut pas confondre <i>Identité de genre</i> et <i>Expression de genre</i> sinon on va déjà mal partir...</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="referrer" class="col-form-label col-md-2">Forum d'exfiltration</label>
                            <div class="col-md-10">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input checked="checked" id="referrer_none.none" name="referrer" type="radio" value="none.none" {{ old('referrer') == 'none.none' ? 'checked' : '' }} class="custom-control-input">
                                    <label for="referrer_none.none" class="custom-control-label mb-2 mb-md-0"><img src="{{ url('/img/forums/4sucres.org.jpg') }}" class="rounded img-fluid" width="64px"></label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input name="referrer" id="referrer_avenoel.org" type="radio" value="avenoel.org" {{ old('referrer') == 'avenoel.org' ? 'checked' : '' }} class="custom-control-input">
                                    <label for="referrer_avenoel.org" class="custom-control-label mb-2 mb-md-0"><img src="{{ url('/img/forums/avenoel.org.jpg') }}" class="rounded img-fluid" width="64px"></label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input name="referrer" id="referrer_jeuxvideo.com" type="radio" value="jeuxvideo.com" {{ old('referrer') == 'jeuxvideo.com' ? 'checked' : '' }} class="custom-control-input">
                                    <label for="referrer_jeuxvideo.com" class="custom-control-label mb-2 mb-md-0"><img src="{{ url('/img/forums/jeuxvideo.com.jpg') }}" class="rounded img-fluid" width="64px"></label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input name="referrer" id="referrer_2sucres.org" type="radio" value="2sucres.org" {{ old('referrer') == '2sucres.org' ? 'checked' : '' }} class="custom-control-input">
                                    <label for="referrer_2sucres.org" class="custom-control-label mb-2 mb-md-0"><img src="{{ url('/img/forums/2sucres.org.jpg') }}" class="rounded img-fluid" width="64px"></label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input name="referrer" id="referrer_lebunker.net" type="radio" value="lebunker.net" {{ old('referrer') == 'lebunker.net' ? 'checked' : '' }} class="custom-control-input">
                                    <label for="referrer_lebunker.net" class="custom-control-label mb-2 mb-md-0"><img src="{{ url('/img/forums/lebunker.net.jpg') }}" class="rounded img-fluid" width="64px"></label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input name="referrer" id="referrer_onche.party" type="radio" value="onche.party" {{ old('referrer') == 'onche.party' ? 'checked' : '' }} class="custom-control-input">
                                    <label for="referrer_onche.party" class="custom-control-label mb-2 mb-md-0"><img src="{{ url('/img/forums/onche.party.jpg') }}" class="rounded img-fluid" width="64px"></label>
                                </div>
                                <br>

                                @if ($errors->has('referrer'))
                                    <small class="text-danger">{{ $errors->referrer }}</small><br>
                                @endif

                                <span class="help-block">Prends le premier choix si tu ne souhaites pas subir de discrimination raciale.</span>
                            </div>
                        </div>

                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger">
                                {{ $errors->first('g-recaptcha-response') }}
                            </span>
                        @endif
                    </div>
                    <div class="card-footer bg-light">
                        <div class="text-center mb-3">
                            <small>En t'inscrivant et en utilisant nos services, tu déclares avoir lu et accepter sans réserve les <a href="{{ route('terms') }}">Conditions générales d'utilisation</a>.</small>
                        </div>

                        <div class="text-right">
                            {!! NoCaptcha::displaySubmit('register', 'Inscription', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>

                {!! BootForm::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
