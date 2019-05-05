@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row justify-content-between">
                        @auth
                            <div class="col-auto">
                                @can('create discussions')
                                    <a href="#" class="btn btn-primary">Nouveau sujet</a>
                                @endcan
                            </div>
                        @endauth
                    </div>
                </div>
                <ul class="discussion-list">
                    <li class="discussion-head">
                        <span class="discussion-icon"></span>
                        <span class="discussion-title">Sujet</span>
                        <span class="discussion-user">Auteur</span>
                        <span class="discussion-nb">Nb</span>
                        <span class="discussion-date">Dernier</span>
                    </li>
                    @isset($sticky_discussions)
                        @foreach ($sticky_discussions as $discussion)
                            <li class="{{ $loop->index%2 ? 'white' : 'blue' }}">
                                <span class="discussion-icon"><i class="fas fa-map-pin text-success"></i></span>
                                <span class="discussion-title"><a href="{{ route('discussion.show', [$discussion->id, $discussion->slug]) }}">{{ $discussion->title }}</a></span>
                                <span class="discussion-user">{{ $discussion->user->display_name }}</span>
                                <span class="discussion-nb">{{ $discussion->replies }}</span>
                                <span class="discussion-date">{{ $discussion->presented_last_reply_at }}</span>
                            </li>
                        @endforeach
                    @endisset
                    @foreach ($discussions as $discussion)
                        <li class="{{ $loop->index%2 ? 'white' : 'blue' }}">
                            <span class="discussion-icon"><i class="fas fa-folder text-warning"></i></span>
                            <span class="discussion-title"><a href="{{ route('discussion.show', [$discussion->id, $discussion->slug]) }}">{{ $discussion->title }}</a></span>
                            <span class="discussion-user">{{ $discussion->user->display_name }}</span>
                            <span class="discussion-nb">{{ $discussion->replies }}</span>
                            <span class="discussion-date">{{ $discussion->presented_last_reply_at }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="card-body mx-auto pb-0">
                    {{ $discussions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
