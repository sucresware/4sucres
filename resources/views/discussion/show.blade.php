@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        @foreach($posts as $post)
            <div class="p-3 row no-gutters {{ $loop->index%2 ? 'white' : 'blue' }}">
                <div class="col-auto mr-3">
                    <img src="{{ url('/img/guest.png') }}" class="post-image rounded">
                </div>
                <div class="col">
                    <div class="float-right">
                        @if ($post->user == auth()->user())
                            <a href="{{ route('discussions.posts.edit', [$discussion->id, $discussion->slug, $post->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Modifier</a>
                        @endif
                    </div>

                    <strong>{{ $post->user->display_name }}</strong>
                    {{ $post->created_at->format('d/m/Y H:i:s') }}
                    @if ($post->created_at != $post->updated_at)
                        <span class="text-muted">(modifié le {{ $post->updated_at->format('d/m/Y H:i:s') }})</span>
                    @endif

                    <hr class="my-2">

                    <div class="post-content">
                        {!! $post->presented_body !!}
                    </div>
                </div>
            </div>
        @endforeach

        <div class="card-body mx-auto pb-0">
            {{ $posts->links() }}
        </div>

        <div class="card-body pb-0">
        Répondre:
            @include('discussion._reply')
        </div>
    </div>
</div>

@endsection
