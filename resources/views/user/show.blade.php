@extends('layouts.app')

@section('title')
    Profil de {{ $user->display_name }}
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="margin-top: 50px">
                <div class="text-center">
                    <img src="{{ $user->avatar ? url('storage/avatars/' . $user->avatar) : url('/img/guest.png') }}" class="img-fluid rounded mb-3" width="100" style="margin-top: -45px;">
                    <div>
                        <strong>
                            <big>
                                {{ $user->display_name }}
                            </big>
                        </strong>
                    </div>

                    <div class="badge badge-light">
                        <i class="fas fa-circle {{ $user->online ? 'text-success' : 'text-danger' }} mr-1"></i>
                        {{ $user->online ? 'En ligne' : 'Hors ligne' }}
                    </div>

                    <hr>

                    <h3 class="h5">Profil du Sucre</h5>
                    <div class="p-1">
                        <strong>Classification :</strong> {{ $user->shown_role }}<br>
                        <strong>Membre depuis :</strong> {{ ($user->created_at->diffInDays(now()) < 1) ? 'aujourd\'hui' : $user->created_at->diffInDays(now()) . ' jour(s)' }} ({{ $user->created_at->format('d/m/Y') }})<br>
                        <strong>Dernière activité :</strong> {{ $user->last_activity->diffForHumans() }}<br>
                    </div>

                    <hr>

                    <h3 class="h5">Statistiques</h5>
                    <div class="p-1">
                        <strong>Nombre de topics:</strong> {{ $discussions = \App\Models\Discussion::public()->where('user_id', $user->id)->count() }}<br>
                        <strong>Nombre de messages:</strong> {{ \App\Models\Post::where('user_id', $user->id)->whereHas('discussion', function($q){$q->public();})->count() - $discussions}}<br>
                    </div>

                    <hr>

                    <h3 class="h5">Dernières participations</h5>
                    <div class="p-1 pb-3">
                        @foreach (\App\Models\Post::where('user_id', $user->id)->whereHas('discussion', function($q){$q->public();})->orderBy('updated_at', 'DESC')->limit(10)->get() as $post)
                            <a href="{{ route('discussions.show', [$post->discussion->id, $post->discussion->slug]) }}">{{ $post->discussion->title }}</a><br>
                        @endforeach
                    </div>

                    <hr>

                    <h3 class="h5">Succès</h5>
                    <div class="p-3 pb-3">
                        @foreach ($user->achievements as $achievement)
                            <div class="row align-items-center border rounded no-gutters mb-1 p-2">
                                <div class="col-auto mr-3">
                                    <img src="{{ url('/img/achievements/' . $achievement->image) }}" class="img-fluid" width="60px">
                                </div>
                                <div class="col text-left">
                                    <strong>{{ $achievement->name }}</strong><br>
                                    {{ $achievement->description }}<br>
                                    <small>Obtenu le {{ \Carbon\Carbon::parse($achievement->pivot->unlocked_at)->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="text-right">
                        @auth
                            @if ($user->id == user()->id)
                                <a href="{{ route('user.edit', $user->name) }}" class="btn btn-primary">Modifier mon profil</a>
                            @else
                                <a href="{{ route('private_discussions.create', [$user->id, $user->name]) }}" class="btn btn-primary">Envoyer un message privé</a>
                                @if (user()->can('bypass users guard'))
                                    <a href="{{ route('user.edit', $user->name) }}" class="btn btn-secondary">Modifier le profil</a>
                                @endif
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
