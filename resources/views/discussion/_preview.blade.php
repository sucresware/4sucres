<div class="row mx-0 gutters-sm align-items-center px-0 py-3 px-md-3 d-flex"
    data-action="open-discussion"
    data-id="{{ $discussion->id }}"
    data-slug="{{ $discussion->slug }}">

    @if (!$discussion->private)
        <div class="d-none d-lg-block col-auto px-0">
            <img src="{{ $discussion->user->avatar_link }}" class="rounded" style="width: 32px; height: 32px;">
        </div>
    @endif

    <div class="col overflow-ellipsis">
        <div class="discussion-title overflow-ellipsis mb-2 mb-lg-0">
            @if ($discussion->sticky)
                <span class="badge badge-info px-1">
                    <i class="fas fa-map-pin text-white fa-fw"></i>
                </span>
            @else
                @if ($discussion->locked)
                    <span class="badge badge-warning px-1">
                        <i class="fas fa-lock text-white fa-fw"></i>
                    </span>
                @endif
            @endif

            @if (!$discussion->private && $discussion->category->id != \App\Models\Category::CATEGORY_GLOBAL)
                <a href="{{ route('discussions.categories.index', [$discussion->category->id, $discussion->category->slug]) }}" class="badge badge-primary">
                    <i class="fas fa-fw fa-hashtag"></i> {{ ltrim($discussion->category->name, '#') }}
                </a>
            @endif

            @if (!user() || in_array($discussion->id, $user_has_read))
                <a href="{{ $discussion->link }}">{{ $discussion->title }}</a>
            @else
                <strong><a href="{{ $discussion->link }}">{{ $discussion->title }}</a></strong>
            @endif
        </div>
        <div class="text-small overflow-ellipsis">
            <a href="{{ $discussion->user->link }}">{{ $discussion->user->display_name }}</a> &middot; {{ $discussion->created_at->format('d/m/Y à H:i') }}
        </div>
    </div>

    @if ($discussion->private)
        <div class="col-auto text-small">
            @foreach($discussion->members as $user)
                @if ($user->id != user()->id)
                    <a href="{{ $user->link }}"><img src="{{ $user->avatar_link }}" class="img-fluid rounded mr-1" width="16"></a>
                    <a href="{{ $user->link }}">{{ $user->display_name }}</a>
                @endif
            @endforeach
        </div>
    @endif

    <div class="col-12 overflow-ellipsis border-none col-lg-fixed last-activity text-small">
        @if ($discussion->latestPost)
            <div class="row align-items-center no-gutters">
                <div class="col-auto d-none d-lg-flex"><i class="far fa-clock fa-fw mr-1"></i></div>
                <div class="col overflow-ellipsis">
                    <div class="d-none d-lg-block mb-lg-1"><a href="{{ $discussion->latestPost->link }}">{{ $discussion->presented_last_reply_at }}</a></div>
                    <div class="d-inline d-lg-none"><a href="{{ $discussion->latestPost->link }}">{{ $discussion->last_reply_at->diffForHumans() }}</a> par</div>
                    <div class="d-inline d-lg-block">
                        <a href="{{ $discussion->latestPost->user->link }}"><img src="{{ $discussion->latestPost->user->avatar_link }}" class="img-fluid rounded mr-1" width="16"></a>
                        <a href="{{ $discussion->latestPost->user->link }}">{{ $discussion->latestPost->user->display_name }}</a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="col-12 border-none col-lg-fixed replies-counter text-small">
        @if ($discussion->presented_replies)
            <i class="far fa-comments fw-fw mr-1 d-none d-ld-none d-lg-inline {{ $discussion->presented_replies > 10 ? 'text-danger' : '' }}"></i> {{ $discussion->presented_replies }}
        @else
            <i class="far fa-comments fw-fw mr-1 d-none d-ld-none d-lg-inline"></i> 0
        @endif
        <span class="d-inline d-lg-none">{{ Str::plural('réponse', $discussion->presented_replies) }}</span>
    </div>
</div>