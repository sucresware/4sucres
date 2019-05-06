@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-3">{{ $discussion->title }}</h1>

    <div class="card mb-3">
        @foreach($posts as $post)
            <div class="p-3 row no-gutters {{ $loop->index%2 ? 'white' : 'blue' }}">
                <div class="col-auto mr-3">
                    <img src="{{ url('/img/guest.png') }}" class="post-image rounded">
                </div>
                <div class="col">
                    <div class="float-right">
                        @if ($post->user == auth()->user())
                            <a href="{{ route('discussions.posts.edit', [$discussion->id, $discussion->slug, $post->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                            <a href="{{ route('discussions.posts.delete', [$discussion->id, $discussion->slug, $post->id]) }}" class="btn btn-primary"><i class="fas fa-trash"></i></a>
                        @endif
                    </div>

                    <strong>{{ $post->user->display_name }}</strong> <small>{{ '@' . $post->user->name }}</small><br>
                    <small>le {{ $post->created_at->format('d/m/Y à H:i:s') }}
                    @if ($post->created_at != $post->updated_at)
                        <span class="text-muted">(modifié le {{ $post->updated_at->format('d/m/Y à H:i:s') }})</span>
                    @endif</small>

                    <hr>

                    <div class="post-content">
                        @if (!$post->deleted)
                            {!! $post->presented_body !!}
                        @else
                            <i>Ce message a été supprimé</i>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pb-0">
        {{ $posts->links() }}
    </div>

    <div class="card">
        <div class="card-body bg-light">
            <h2 class="h6">Répondre</h2>
            @include('discussion._reply')
        </div>
    </div>
</div>

@endsection
