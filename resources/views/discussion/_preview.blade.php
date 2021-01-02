<div class="row mx-0 gutters-sm align-items-center px-0 py-3 px-md-3 d-flex" data-action="open-thread"
    data-id="{{ $thread->id }}" data-slug="{{ $thread->slug }}">

    @if (!$thread->private)
    <div class="d-none d-lg-block col-auto px-0">
        <img src="{{ $thread->user->avatar_link }}" class="rounded" style="width: 32px; height: 32px;">
    </div>
    @endif

    <div class="col overflow-ellipsis">
        <div class="thread-title overflow-ellipsis mb-2 mb-lg-0">
            @if ($thread->sticky)
            <span class="badge badge-info px-1">
                <i class="fas fa-map-pin text-white fa-fw"></i>
            </span>
            @endif
            @if ($thread->locked)
            <span class="badge badge-warning px-1">
                <i class="fas fa-lock text-white fa-fw"></i>
            </span>
            @endif

            @if (!$thread->private && $thread->board->id != \App\Models\Board::CATEGORY_GLOBAL)
            <a href="{{ route('threads.boards.index', [$thread->board->id, $thread->board->slug]) }}"
                class="badge badge-primary">
                <i class="fas fa-fw fa-hashtag"></i> {{ ltrim($thread->board->name, '#') }}
            </a>
            @endif

            @if (!user() || in_array($thread->id, $user_has_read))
            <a href="{{ $thread->link }}">{{ $thread->title }}</a>
            @else
            <strong><a href="{{ $thread->link }}">{{ $thread->title }}</a></strong>
            @endif
        </div>
        <div class="text-small overflow-ellipsis">
            <a href="{{ $thread->user->link }}">{{ $thread->user->display_name }}</a> &middot;
            {{ $thread->created_at->format('d/m/Y à H:i') }}
        </div>
    </div>

    @if ($thread->private)
    <div class="col-auto text-small">
        @foreach($thread->members as $user)
        @if ($user->id != user()->id)
        <a href="{{ $user->link }}"><img src="{{ $user->avatar_link }}" class="img-fluid rounded mr-1" width="16"></a>
        <a href="{{ $user->link }}">{{ $user->display_name }}</a>
        @endif
        @endforeach
    </div>
    @endif

    <div class="col-12 overflow-ellipsis border-none col-lg-fixed last-activity text-small">
        @if ($thread->latestPost)
        <div class="row align-items-center no-gutters">
            <div class="col-auto d-none d-lg-flex"><i class="far fa-clock fa-fw mr-1"></i></div>
            <div class="col overflow-ellipsis">
                <div class="d-none d-lg-block mb-lg-1"><a
                        href="{{ $thread->latestPost->link }}">{{ $thread->presented_last_reply_at }}</a></div>
                <div class="d-inline d-lg-none"><a
                        href="{{ $thread->latestPost->link }}">{{ $thread->last_reply_at->diffForHumans() }}</a> par
                </div>
                <div class="d-inline d-lg-block">
                    <a href="{{ $thread->latestPost->user->link }}"><img
                            src="{{ $thread->latestPost->user->avatar_link }}" class="img-fluid rounded mr-1"
                            width="16"></a>
                    <a href="{{ $thread->latestPost->user->link }}">{{ $thread->latestPost->user->display_name }}</a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-12 border-none col-lg-fixed replies-counter text-small">
        @if ($thread->presented_replies)
        <i
            class="far fa-comments fw-fw mr-1 d-none d-ld-none d-lg-inline {{ $thread->presented_replies > 10 ? 'text-danger' : '' }}"></i>
        {{ $thread->presented_replies }}
        @else
        <i class="far fa-comments fw-fw mr-1 d-none d-ld-none d-lg-inline"></i> 0
        @endif
        <span class="d-inline d-lg-none">{{ Str::plural('réponse', $thread->presented_replies) }}</span>
    </div>
</div>