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
                    <h1>{{ $user->display_name }}</h1>

                    <hr>

                    <h3 class="h5">Profil du Sucre</h5>
                    <div class="p-1">
                        <strong>Grade:</strong> {{ $user->shown_role }}<br>
                        <strong>Membre depuis:</strong> {{ ($user->created_at->diffInDays(now()) < 1) ? 'aujourd\'hui' : $user->created_at->diffInDays(now()) . ' jour(s)' }} ({{ $user->created_at->format('d/m/Y') }})<br>
                        <strong>Dernière connexion:</strong> {{ $user->updated_at->diffForHumans() }}<br>
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
                </div>
                <div class="card-footer bg-light">
                    <div class="text-right">
                        @if (auth()->check() && ($user->id == auth()->user()->id))
                            <a href="{{ route('user.edit', [$user->id, $user->name]) }}" class="btn btn-primary">Modifier mon profil</a>
                        @else
                            <a href="{{ route('private_discussions.create', [$user->id, $user->name]) }}" class="btn btn-primary">Envoyer un message privé</a>
                            @if (auth()->check() && auth()->user()->can('bypass users guard'))
                                <a href="{{ route('user.edit', [$user->id, $user->name]) }}" class="btn btn-primary">Modifier le profil</a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
