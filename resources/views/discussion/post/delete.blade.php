@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <form action="{{ route('discussions.posts.destroy', [$discussion->id, $discussion->slug, $post->id]) }}" method="post">
            <div class="card-body">
                @if ($post->id == $discussion->posts[0]->id)
                    <h1 class="text-danger h6">Suppression de la discussion</h1>
                    <p>Tu veux vraiment faire disparaitre ta discussion avec les {{ $discussion->posts->count() }} message(s) ?</p>
                @else
                    <h1 class="text-danger h6">Suppression</h1>
                    <p>Tu veux vraiment faire disparaitre ça ?</p>
                @endif
                @include('discussion.post._show_as_quote', compact('post'))
                @csrf
                @method('delete')
            </div>
            <div class="card-footer bg-light">
                <div class="text-right">
                    <a href="{{ route('discussions.show', [$discussion->id, $discussion->slug]) }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-danger">
                        @if ($post->id == $discussion->posts[0]->id)
                            Tout dégage !
                        @else
                            Ça dégage
                        @endif
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
