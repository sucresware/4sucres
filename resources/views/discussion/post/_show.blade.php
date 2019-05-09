<div class="p-3 row no-gutters">
    <div class="col-auto mr-3">
        <a href="{{ route('user.show', [$post->user->id, $post->user->name]) }}"><img src="{{ $post->user->avatar ? url('storage/avatars/' . $post->user->avatar) : url('/img/guest.png') }}" class="post-image rounded"></a>
    </div>
    <div class="col">
        @if (!$post->discussion->private)
            <div class="float-right">
                @if (auth()->check())
                    <a class="mr-1" href="javascript:void(0)" data-placement="left" data-popover-content="#react_to_{{ $post->id }}" data-toggle="popover" data-trigger="focus"><i class="far fa-fw fa-smile"></i></a>
                    <div class="d-none" id="react_to_{{ $post->id }}">
                        <div class="popover-heading">
                        </div>
                        <div class="popover-body">
                            <div class="row no-gutters">
                                <div class="col-3"><a href="javascript:void(0)" data-action='reactOnPost' data-reaction="angry" data-id='{{ $post->id }}'><img src="{{ url('/img/reactions/angry.png') }}" class="img-fluid" style="width: 30px;"></a></div>
                                <div class="col-3"><a href="javascript:void(0)" data-action='reactOnPost' data-reaction="happy" data-id='{{ $post->id }}'><img src="{{ url('/img/reactions/happy.png') }}" class="img-fluid" style="width: 30px;"></a></div>
                                <div class="col-3"><a href="javascript:void(0)" data-action='reactOnPost' data-reaction="love" data-id='{{ $post->id }}'><img src="{{ url('/img/reactions/love.png') }}" class="img-fluid" style="width: 30px;"></a></div>
                                <div class="col-3"><a href="javascript:void(0)" data-action='reactOnPost' data-reaction="sad" data-id='{{ $post->id }}'><img src="{{ url('/img/reactions/sad.png') }}" class="img-fluid" style="width: 30px;"></a></div>
                                <div class="col-3"><a href="javascript:void(0)" data-action='reactOnPost' data-reaction="sick" data-id='{{ $post->id }}'><img src="{{ url('/img/reactions/sick.png') }}" class="img-fluid" style="width: 30px;"></a></div>
                                <div class="col-3"><a href="javascript:void(0)" data-action='reactOnPost' data-reaction="sueur" data-id='{{ $post->id }}'><img src="{{ url('/img/reactions/sueur.png') }}" class="img-fluid" style="width: 30px;"></a></div>
                                <div class="col-3"><a href="javascript:void(0)" data-action='reactOnPost' data-reaction="what" data-id='{{ $post->id }}'><img src="{{ url('/img/reactions/what.png') }}" class="img-fluid" style="width: 30px;"></a></div>
                                <div class="col-3"><a href="javascript:void(0)" data-action='reactOnPost' data-reaction="oh" data-id='{{ $post->id }}'><img src="{{ url('/img/reactions/oh.png') }}" class="img-fluid" style="width: 30px;"></a></div>
                            </div>
                        </div>
                    </div>
                    {{--  <div id="standalone" data-emoji-placeholder=":smiley:"></div>  --}}

                    <a class="mr-1" href="javascript:void(0)" data-action='quotePost' data-id='{{ $post->id }}'><i class="fas fa-fw fa-quote-right"></i></a>
                    @if ($post->user->id == auth()->user()->id || auth()->user()->can('bypass discussions guard'))
                        <a class="mr-1" href="{{ route('discussions.posts.edit', [$discussion->id, $discussion->slug, $post->id]) }}"><i class="fas fa-fw fa-edit"></i></a>
                        <a class="mr-1 text-danger" href="{{ route('discussions.posts.delete', [$discussion->id, $discussion->slug, $post->id]) }}"><i class="fas fa-fw fa-trash"></i></a>
                    @endif
                @endif
            </div>
        @endif

        <a href="{{ route('user.show', [$post->user->id, $post->user->name]) }}"><strong>{{ $post->user->display_name }}</strong></a> <small>{{ '@' . $post->user->name }}</small><br>
        <small>le {{ $post->created_at->format('d/m/Y à H:i:s') }}
        @if ($post->created_at != $post->updated_at)
            <span class="text-muted">(modifié le {{ $post->updated_at->format('d/m/Y à H:i:s') }})</span>
        @endif</small>

        <hr>

        <div class="post-content">
            @if (!$post->deleted)
                {!! $post->presented_body !!}
            @else
                @if (auth()->check() && auth()->user()->can('read deleted posts'))
                    <small><i>Message supprimé</i></small><br>
                    <br>

                    {!! $post->presented_body !!}
                @else
                    <small><i>Message supprimé</i></small>
                @endif
            @endif
        </div>
    </div>
</div>