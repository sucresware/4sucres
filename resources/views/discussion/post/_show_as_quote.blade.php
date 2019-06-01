@php
    if (!isset($current)) {
        $current = (new stdClass);
        $current->discussion_id = null;
    }
@endphp

<blockquote class="shadow-sm">
    <div class="quote-header d-flex justify-content-between">
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
    <hr class="mt-2 mb-3">
    <div class="quote-content post-content">
        @if ($post->deleted_at)
            <div class="text-danger mb-3"><i class="fas fa-times"></i> Message supprimé</div>
        @endif
        @if (!$post->deleted_at || auth()->check() && user()->can('read deleted posts'))
            @if ($post->deleted_at) <div class="deleted-message-content text-italic text-muted"> @endif
                {!! $post->presented_light_body !!}
            @if ($post->deleted_at) </div> @endif
        @endif
    </div>
</blockquote>