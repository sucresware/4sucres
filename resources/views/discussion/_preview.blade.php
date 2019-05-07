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

    <div class="d-none d-sm-block col-auto pr-0">
        <img src="{{ $discussion->user->avatar ? url('storage/avatars/' . $discussion->user->avatar) : url('/img/guest.png') }}" class="rounded" style="width: 50px;">
    </div>
    <div class="col">
        <div class="discussion-title">
            @if (auth()->check() && $discussion->has_read()->wherePivot('user_id', auth()->user()->id)->count())
                <a href="{{ route('discussions.show', [$discussion->id, $discussion->slug]) }}">{{ $discussion->title }}</a>
            @else
                <strong><a href="{{ route('discussions.show', [$discussion->id, $discussion->slug]) }}">{{ $discussion->title }}</a></strong>
            @endif
        </div>
        par <a href="{{ route('user.show', [$discussion->user->id, $discussion->user->name]) }}">{{ $discussion->user->display_name }}</a>, dernière réponse par <a href="{{ route('user.show', [$discussion->posts->last()->user->id, $discussion->posts->last()->user->name]) }}">{{ $discussion->posts->last()->user->display_name }}</a> {{ $discussion->last_reply_at->diffForHumans() }}
    </div>

    @if ($discussion->private)
        <div class="col-auto text-right">
            @foreach($discussion->members as $user)
                {{ $user->name }} <img src="{{ $user->avatar ? url('storage/avatars/' . $user->avatar) : url('/img/guest.png') }}" class="img-fluid rounded" width="16"><br>
            @endforeach
        </div>
    @endif

    <div class="col-12 col-sm-auto text-muted">
        @if ($discussion->presented_replies)
            {{ $discussion->presented_replies }} <i class="fas fa-comments"></i>
        @else
            0 <i class="fas fa-comment"></i>
        @endif
    </div>

    @if (!$discussion->private)
        <div class="d-none d-md-block col-auto">
            <a href="#" class="btn btn-outline-primary" style="width: 200px;">{{ $discussion->category->name }}</a>
        </div>
    @endif
</div>