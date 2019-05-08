<div class="p-2 bg-white border">
    <div class="quote-header mb-2">
        <a href="{{ $post->user->link }}"><img src="{{ $post->user->avatar_link }}" class="rounded" height="14px"></a>
        <a href="{{ $post->user->link }}"><strong>{{ $post->user->display_name }}</strong></a>
        <small>{{ '@' . $post->user->name }}</small>
    </div>
    <div class="quote-content post-content">
        @if (!$post->deleted)
            {!! $post->presented_light_body !!}
        @else
            @if (auth()->check() && auth()->user()->can('read deleted posts'))
                <small><i>Message supprimé</i></small><br>
                <br>

                {!! $post->presented_light_body !!}
            @else
                <small><i>Message supprimé</i></small>
            @endif
        @endif
    </div>
</div>