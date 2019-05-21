@extends('layouts.app')

@section('title')
    Recherche : {{ $query }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-xl-8">
            <div class="text-center font-weight-bold text-uppercase">Rechercher les :</div>
            <ul class="nav nav-pills justify-content-center mt-2 mb-3">
                <a href="{{ route('search.query') }}?query={{ $query }}&scope=posts" class="mx-2 nav-link {{ (($scope ?? 'posts') == 'posts' ? 'active' : '') }}">Posts</a>
                <a href="{{ route('search.query') }}?query={{ $query }}&scope=discussions" class="mx-2 nav-link {{ (($scope ?? 'posts') == 'discussions' ? 'active' : '') }}">Discussions</a>
                <a href="{{ route('search.query') }}?query={{ $query }}&scope=users" class="mx-2 nav-link {{ (($scope ?? 'posts') == 'users' ? 'active' : '') }}">Membres</a>
            </ul>

            @isset ($posts)
                <div class="card shadow-sm mb-3">
                    <div class="card-header">
                        {{ $count = $posts->total() }} {{ str_plural('post', $count) }} {{ str_plural('correspondant', $count) }}
                    </div>
                    @forelse($posts as $post)
                        <div class="{{ $loop->index%2 ? 'white' : 'blue' }}">
                            <div class="p-3">
                                <p>
                                    <a href="{{ $post->link }}">{{ $post->discussion->title }}</a><br>
                                    <small>{!! $post->trimmed_body !!}</small>
                                </p>

                                <a href="{{ $post->user->link }}"><img src="{{ $post->user->avatar_link }}" class="rounded" height="14px"></a>
                                <a href="{{ $post->user->link }}"><strong>{{ $post->user->display_name }}</strong></a>
                                le {{ $post->presented_created_at }}
                            </div>
                        </div>
                    @empty
                        <div class="card-body">
                            <span class="text-danger">
                                Ta recherche n'a donné aucun résultat 😅
                            </span>
                        </div>
                    @endforelse
                    {!! $posts->appends(request()->input())->onEachSide(1)->links() !!}
                </div>
            @endisset
            @isset ($discussions)
                <div class="card shadow-sm mb-3">
                    <div class="card-header">
                        {{ $count = $discussions->total() }} {{ str_plural('discussion', $count) }} {{ str_plural('correspondante', $count) }}
                    </div>
                    @forelse($discussions as $discussion)
                        <div class="{{ $loop->index%2 ? 'white' : 'blue' }}">
                            <div class="p-3">
                                <p>
                                    <a href="{{ $discussion->link }}">{!! $discussion->title !!}</a><br>
                                </p>

                                <a href="{{ $discussion->user->link }}"><img src="{{ $discussion->user->avatar_link }}" class="rounded" height="14px"></a>
                                <a href="{{ $discussion->user->link }}"><strong>{{ $discussion->user->display_name }}</strong></a>
                                le {{ $discussion->created_at->format('d/m/Y à H:i:s') }}
                            </div>
                        </div>
                    @empty
                        <div class="card-body">
                            <span class="text-danger">
                                Ta recherche n'a donné aucun résultat 😅
                            </span>
                        </div>
                    @endforelse
                    {!! $discussions->appends(request()->input())->onEachSide(1)->links() !!}
                </div>
            @endisset
            @isset ($users)
                <div class="card shadow-sm mb-3">
                    <div class="card-header">
                        {{ $count = $users->total() }} {{ str_plural('utilisateur', $count) }} {{ str_plural('correspondant', $count) }}
                    </div>
                    @forelse($users as $user)
                        <div class="{{ $loop->index%2 ? 'white' : 'blue' }}">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col-auto pr-0">
                                        <a href="{{ $user->link }}"><img src="{{ $user->avatar_link }}" class="rounded" height="32px"></a>
                                    </div>
                                    <div class="col">
                                        <a href="{!! $user->link !!}"><strong>{!! $user->display_name_for_search !!}</strong></a><br>
                                        <a href="{!! $user->link !!}"><small>{!! '@' . $user->name_for_search !!}</small></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card-body">
                            <span class="text-danger">
                                Ta recherche n'a donné aucun résultat 😅
                            </span>
                        </div>
                    @endforelse
                    {!! $users->appends(request()->input())->onEachSide(1)->links() !!}
                </div>
            @endisset
        </div>
    </div>
</div>
@endsection
