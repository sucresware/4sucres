<div class="row mx-0 gutters-sm align-items-center p-3 d-flex"
    data-action="open-discussion"
    data-id="{{ $discussion->id }}"
    data-slug="{{ $discussion->slug }}">

    @if ($discussion->sticky)
        <div class="sidetag">
            <i class="fas fa-fw fa-map-pin text-success"></i>
        </div>
    @else
        @if ($discussion->locked)
            <div class="sidetag">
                <i class="fas fa-fw fa-lock text-warning"></i>
            </div>
        @endif
    @endif

    @if (!$discussion->private)
        <div class="d-none d-lg-block col-auto px-0">
            <img src="{{ $discussion->user->avatar_link }}" class="rounded" style="width: 50px;">
        </div>
    @endif

    <div class="col overflow-ellipsis">
        <div class="discussion-title overflow-ellipsis mb-2 mb-lg-0">
            @if (!user() || in_array($discussion->id, $user_has_read))
                <a href="{{ $discussion->link }}">{{ $discussion->title }}</a>
            @else
                <strong><a href="{{ $discussion->link }}">{{ $discussion->title }}</a></strong>
            @endif
        </div>
        <div class="text-small overflow-ellipsis">
            par <a href="{{ $discussion->user->link }}">{{ $discussion->user->display_name }}</a> le {{ $discussion->created_at->format('d/m/Y à H:i') }}
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
        <span class="d-inline d-lg-none">{{ str_plural('réponse', $discussion->presented_replies) }}</span>
    </div>

    @if (!$discussion->private)
        <div class="d-none d-lg-block col-lg-fixed category pr-0">
            <a href="{{ route('discussions.categories.index', [$discussion->category->id, $discussion->category->slug]) }}"
                class="btn btn-outline-primary btn-block">{{ $discussion->category->name }}</a>
        </div>
    @endif
</div>