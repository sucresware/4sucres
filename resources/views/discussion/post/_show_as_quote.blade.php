<blockquote class="p-2 shadow-sm">
    <div class="quote-header mb-2 d-flex justify-content-between">
        <div>
            <a href="{{ $post->user->link }}" class="align-middle"><img src="{{ $post->user->avatar_link }}" class="rounded" height="14px"></a>
            <a href="{{ $post->user->link }}"><strong>{{ $post->user->display_name }}</strong></a>
            <small>{{ '@' . $post->user->name }}</small>
        </div>
        <div>
            @if ($post->discussion_id !== $current->discussion_id)
                <a href="{{ $post->discussion->link }}" target="_blank" title="Voir le topic" class="text-small mr-2">
                    {{ $post->discussion->title }}
                </a>
            @endif
            
            <a href="{{ $post->getLinkAttribute() }}" title="Voir le contexte" class="text-small">
                <i class="fas fa-link"></i>
            </a>
        </div>
    </div>
    <div class="quote-content post-content">
    @if (!$post->deleted)
        {!! $post->presented_body !!}
    @else
        @if (auth()->check() && user()->can('read deleted posts'))
            <span class="text-danger"><i class="fas fa-times"></i> Message supprimé</span><br>
            <br>
            <div class="deleted-message-content text-italic text-muted">
                {!! $post->presented_body !!}
            </div>
        @else
            <span class="text-danger"><i class="fas fa-times"></i> Message supprimé</span>
        @endif
    @endif
    </div>
</blockquote>