@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        @foreach($posts as $post)
            <div class="p-3 row no-gutters {{ $loop->index%2 ? 'white' : 'blue' }}">
                <div class="col-auto mr-3">
                    <img src="{{ url('/img/guest.png') }}" class="post-image rounded">
                </div>
                <div class="col">
                    <strong>{{ $post->user->display_name }}</strong><br>
                    {{ $post->updated_at->format('d/m/Y H:i:s') }}
                    <hr class="my-2">

                    <div class="post-content">
                        {!! $post->body !!}
                    </div>
                </div>
            </div>
        @endforeach

        <div class="card-body mx-auto pb-0">
            {{ $posts->links() }}
        </div>
    </div>
</div>

@endsection
