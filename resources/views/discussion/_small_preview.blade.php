<div class="row align-items-center">
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

    <div class="d-none d-sm-block col-auto pr-0 pl-4">
        <img src="{{ $discussion->user->avatar_link }}" class="rounded" style="width: 28px;">
    </div>
    <div class="col">
        <div class="discussion-title">
            @if (!user() || in_array($discussion->id, $user_has_read))
                <a href="{{ route('discussions.show', [$discussion->id, $discussion->slug]) }}">{{ $discussion->title }}</a>
            @else
                <strong><a href="{{ route('discussions.show', [$discussion->id, $discussion->slug]) }}">{{ $discussion->title }}</a></strong>
            @endif
        </div>
    </div>

    <div class="col-12 col-sm-auto text-muted">
        @if ($discussion->presented_replies)
            {{ $discussion->presented_replies }} <i class="fas fa-comments {{ $discussion->presented_replies > 10 ? 'text-danger' : '' }}"></i>
        @else
            0 <i class="fas fa-comment"></i>
        @endif
    </div>

    <div class="col-12 col-sm-auto text-muted">
        <i class="far fa-clock"></i> {{ $discussion->presented_last_reply_at }}
    </div>

    @if (!$discussion->private)
        <div class="d-none d-md-block col-auto">
            <a href="#" class="btn btn-sm btn-outline-primary" style="width: 150px;">{{ $discussion->category->name }}</a>
        </div>
    @endif
</div>