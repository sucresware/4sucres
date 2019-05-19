<blockquote class="p-2 shadow-sm">
    <div class="quote-header mb-2 d-flex justify-content-between">
        <div>
            <a href="{{ $post->user->link }}" class="align-middle"><img src="{{ $post->user->avatar_link }}" class="rounded" height="14px"></a>
            <a href="{{ $post->user->link }}"><strong>{{ $post->user->display_name }}</strong></a>
            <small>{{ '@' . $post->user->name }}</small>
        </div>
        <div>
            <a href="{{ $post->getLinkAttribute() }}" title="Voir l'original">
                <i class="fas fa-link"></i>
            </a>
        </div>
    </div>
    <div class="quote-content post-content">
        @include('discussion.post._post_content')
    </div>
</blockquote>