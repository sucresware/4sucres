<div class="row align-items-center">
    @if ($thread->sticky)
    <div class="sidetag">
        <i class="fas fa-fw fa-map-pin text-success"></i>
    </div>
    @else
    @if ($thread->locked)
    <div class="sidetag">
        <i class="fas fa-fw fa-lock text-warning"></i>
    </div>
    @endif
    @endif

    <div class="d-none d-sm-block col-auto pr-0 pl-4">
        <img src="{{ $thread->user->avatar_link }}" class="rounded" style="width: 28px;">
    </div>
    <div class="col">
        <div class="thread-title">
            @if (!user() || in_array($thread->id, $user_has_read))
            <a href="{{ route('threads.show', [$thread->id, $thread->slug]) }}">{{ $thread->title }}</a>
            @else
            <strong><a
                    href="{{ route('threads.show', [$thread->id, $thread->slug]) }}">{{ $thread->title }}</a></strong>
            @endif
        </div>
    </div>

    <div class="col-12 col-sm-auto text-muted">
        @if ($thread->presented_replies)
        {{ $thread->presented_replies }} <i
            class="fas fa-comments {{ $thread->presented_replies > 10 ? 'text-danger' : '' }}"></i>
        @else
        0 <i class="fas fa-comment"></i>
        @endif
    </div>

    <div class="col-12 col-sm-auto text-muted">
        <i class="far fa-clock"></i> {{ $thread->presented_last_reply_at }}
    </div>

    @if (!$thread->private)
    <div class="d-none d-md-block col-auto">
        <a href="#" class="btn btn-sm btn-outline-primary" style="width: 150px;">{{ $thread->board->name }}</a>
    </div>
    @endif
</div>