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
            <div class="card mb-3">
                <div class="card-header">
                    Connexions
                </div>
                <div class="card-body dimmed-border-bottom">
                    <p>Connectez vos comptes à 4sucres pour pouvoir accéder à des intégrations spéciales !</p>
                </div>
                <div class="card-body dimmed-border-bottom">
                    <div class="text-center font-weight-bold text-uppercase mb-3">Intégration Discord</div>

                    <div class="alert blue border">
                        <div class="row align-items-center">
                            <div class="col col-md-8">
                                <p>
                                    <strong>Incroyable du cul !</strong> Tu peux maintenant utiliser les emojis de tes serveurs Discord ! Du jamais vu sur les JVC-likes.
                                    <br>
                                    En fait, c'est un peu comme Discord Nitro, mais gratuitement, et sur 4sucres.
                                </p>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="optin_discord_emojis" name="optin_discord_emojis" {{ old('optin_discord_emojis', $user->getSetting('webpush.enabled', 0)) ? 'checked' : '' }} value="1">
                                    <label class="custom-control-label" for="optin_discord_emojis">
                                        Je veux niquer le système ! (expérimental)
                                    </label>
                                </div>
                            </div>

                            <div class="d-none d-md-flex col-md-4 pr-1">
                                <a href='{{ url('/img/settings/discord.connector.png') }}' data-toggle='lightbox' data-type='image'>
                                    <img src="{{ url('/img/settings/discord.connector.png') }}" class="img-fluid rounded">
                                </a>
                            </div>
                        </div>

                    </div>
                        <div class="alert white border">
                            @foreach ($user->discord_guilds as $guild)
                                @if (count($guild->emojis))
                                    <div class="text-uppercase font-weight-bold font-sm">{{ $guild->name }}</div><br>
                                    @foreach ($guild->emojis as $emoji)
                                        <div class="emoji" style="background-image: url({{ $emoji->link }});" data-toggle="tooltip" data-placement="top" title="{{ $emoji->name }}"></div>
                                    @endforeach
                                    <hr>
                                @endif
                            @endforeach
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection