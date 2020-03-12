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
                    Token
                </div>
                <div class="card-body dimmed-border-bottom">
                    <copy-input
                        type="text"
                        name="token"
                        label="Token personnel 4sucres"
                        value="{{ $user->api_token }}" />
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    Connexions
                </div>
                <div class="card-body dimmed-border-bottom">
                    <div class="text-center font-weight-bold text-uppercase mb-3">Intégration Discord</div>
                        <div class="alert">
                            <div class="row align-items-center">
                                <div class="col col-md-8">
                                    <p>
                                        <strong>Incroyable du cul !</strong> Tu peux maintenant utiliser les emojis de tes serveurs Discord ! Du jamais vu sur les JVC-likes.
                                        <br>
                                        En fait, c'est un peu comme Discord Nitro, mais sur 4sucres.
                                    </p>

                                    @if ($user->can('sync discord emojis'))
                                    @else
                                        <span class="text-danger">Oupsi ! Cette fonctionnalité est réservée aux membres vérifés.</span>
                                    @endif
                                </div>

                                <div class="d-none d-md-flex col-md-4 pr-1">
                                    <a href='{{ url('/img/settings/discord.connector.png') }}' data-toggle='lightbox' data-type='image'>
                                        <img src="{{ url('/img/settings/discord.connector.png') }}" class="img-fluid rounded">
                                    </a>
                                </div>
                            </div>
                        </div>

                        @if (count($user->discord_guilds))
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
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection