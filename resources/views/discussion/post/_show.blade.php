<div class="post p-3 row no-gutters" id="p{{ $post->id }}">
    <div class="col-auto mr-3">
        <a href="{{ $post->user->link }}"><img src="{{ $post->user->avatar_link }}" class="post-image rounded"></a>
    </div>
    <div class="col">
        @if (!$post->thread->private)
        <div class="float-right">
            <a class="mr-1" href="{{ $post->link }}"><i class="fas fa-fw fa-link"></i></a>

            @if (auth()->check())
            {{--  <a class="mr-1" href="javascript:void(0)" data-placement="left" data-popover-content="#react_to_{{ $post->id }}"
            data-toggle="popover" data-trigger="focus"><i class="far fa-fw fa-smile"></i></a> --}}
            @if (!$post->deleted_at)
            <a class="mr-1" href="#reply" data-action='quotePost' data-id='{{ $post->id }}'><i
                    class="fas fa-fw fa-quote-right"></i></a>
            @endif

            @if (($post->user->id == user()->id && !$post->deleted_at) || user()->can('bypass threads guard'))
            <a class="mr-1" href="{{ route('threads.posts.edit', [$thread->id, $thread->slug, $post->id]) }}"><i
                    class="fas fa-fw fa-edit"></i></a>
            @if (!$post->deleted_at)
            <a class="mr-1 text-danger"
                href="{{ route('threads.posts.delete', [$thread->id, $thread->slug, $post->id]) }}"><i
                    class="fas fa-fw fa-trash"></i></a>
            @endif
            @endif
            @endif
        </div>
        @endif

        <a href="{{ $post->user->link }}"><strong>{{ $post->user->display_name }}</strong></a>
        <small>{{ '@' . $post->user->name }}</small><br>
        <small><a href="{{ $post->link }}">{{ $post->presented_date }}</a></small>

        <hr>

        <div class="post-content">
            @if ($post->deleted_at)
            <span class="text-danger"><i class="fas fa-times"></i> Message supprimé</span>
            @endif
            @if (!$post->deleted_at || auth()->check() && user()->can('read deleted posts'))
            @if ($post->deleted_at) <div class="deleted-message-content text-italic text-muted"> @endif
                {!! $post->presented_body !!}
                @if ($post->deleted_at) </div> @endif
            @endif
        </div>
    </div>
</div>