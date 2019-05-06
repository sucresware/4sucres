<div class="p-3 row no-gutters">
    <div class="col-auto mr-3">
        <a href="{{ route('user.show', [$post->user->id, $post->user->name]) }}"><img src="{{ $post->user->avatar ? url('storage/avatars/' . $post->user->avatar) : url('/img/guest.png') }}" class="post-image rounded"></a>
    </div>
    <div class="col">
        @if (!$post->discussion->private)
            <div class="float-right">
                @if (auth()->check() && ($post->user->id == auth()->user()->id || auth()->user()->can('bypass discussions guard')))
                    <a href="{{ route('discussions.posts.edit', [$discussion->id, $discussion->slug, $post->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                    <a href="{{ route('discussions.posts.delete', [$discussion->id, $discussion->slug, $post->id]) }}" class="btn btn-primary"><i class="fas fa-trash"></i></a>
                @endif
            </div>
        @endif

        <a href="{{ route('user.show', [$post->user->id, $post->user->name]) }}"><strong>{{ $post->user->display_name }}</strong></a> <small>{{ '@' . $post->user->name }}</small><br>
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