<blockquote class="p-2 shadow-sm">
    <div class="quote-header mb-2">
        <a href="{{ $post->user->link }}"><img src="{{ $post->user->avatar_link }}" class="rounded" height="14px"></a>
        <a href="{{ $post->user->link }}"><strong>{{ $post->user->display_name }}</strong></a>
        <small>{{ '@' . $post->user->name }}</small>
    </div>
    <div class="quote-content post-content">
        @if (!$post->deleted)
            {!! $post->presented_light_body !!}
        @else
            @if (auth()->check() && user()->can('read deleted posts'))
                <span class="text-danger"><i class="fas fa-times"></i> Message supprimé</span>
                <br>

                {!! $post->presented_light_body !!}
            @else
                <span class="text-danger"><i class="fas fa-times"></i> Message supprimé</span>
            @endif
        @endif
    </div>
</blockquote>