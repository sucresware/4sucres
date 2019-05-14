<div class="post p-3 row no-gutters" id="p{{ $post->id }}">
    <div class="col-auto mr-3">
        <a href="{{ $post->user->link }}"><img src="{{ $post->user->avatar ? url('storage/avatars/' . $post->user->avatar) : url('/img/guest.png') }}" class="post-image rounded"></a>
    </div>
    <div class="col">
        @if (!$post->discussion->private)
            <div class="float-right">
                <a class="mr-1" href="{{ $post->link }}"><i class="fas fa-fw fa-link"></i></a>

                @if (auth()->check())
                    {{--  <a class="mr-1" href="javascript:void(0)" data-placement="left" data-popover-content="#react_to_{{ $post->id }}" data-toggle="popover" data-trigger="focus"><i class="far fa-fw fa-smile"></i></a>  --}}
                    @if (!$post->deleted)
                        <a class="mr-1" href="#reply" data-action='quotePost' data-id='{{ $post->id }}'><i class="fas fa-fw fa-quote-right"></i></a>
                    @endif

                    @if (($post->user->id == user()->id && !$post->deleted) || user()->can('bypass discussions guard'))
                        <a class="mr-1" href="{{ route('discussions.posts.edit', [$discussion->id, $discussion->slug, $post->id]) }}"><i class="fas fa-fw fa-edit"></i></a>
                        @if (!$post->deleted)
                            <a class="mr-1 text-danger" href="{{ route('discussions.posts.delete', [$discussion->id, $discussion->slug, $post->id]) }}"><i class="fas fa-fw fa-trash"></i></a>
                        @endif
                    @endif
                @endif
            </div>
        @endif

        <a href="{{ $post->user->link }}"><strong>{{ $post->user->display_name }}</strong></a> <small>{{ '@' . $post->user->name }}</small><br>
        <small><a href="{{ $post->link }}">le {{ $post->created_at->format('d/m/Y à H:i:s') }}</a>
        @if ($post->created_at != $post->updated_at)
            <span class="text-muted">(modifié le {{ $post->updated_at->format('d/m/Y à H:i:s') }})</span>
        @endif</small>

        <hr>

        <div class="post-content">
            @if (!$post->deleted)
                {!! $post->presented_body !!}
            @else
                @if (auth()->check() && user()->can('read deleted posts'))
                    <small><i>Message supprimé</i></small><br>
                    <br>

                    {!! $post->presented_body !!}
                @else
                    <small><i>Message supprimé</i></small>
                @endif
            @endif
        </div>
    </div>
</div>