@extends('layouts.app')

@section('title')
Supression
@endsection

@section('content')
<div class="container">
    <div class="card">
        <form action="{{ route('threads.posts.destroy', [$thread->id, $thread->slug, $post->id]) }}" method="post">
            <div class="card-body">
                @if ($post->id == $thread->posts[0]->id)
                <h1 class="text-danger h6">Suppression du thread</h1>
                <p>Tu veux vraiment faire disparaitre le thread avec les {{ $thread->posts->count() }} message(s) ?</p>
                @else
                <h1 class="text-danger h6">Suppression</h1>
                <p>Tu veux vraiment faire disparaitre ça ?</p>
                @endif
                @include('discussion.post._show_as_quote', compact('post'))
                @csrf
                @method('delete')
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <a href="{{ route('threads.show', [$thread->id, $thread->slug]) }}"
                        class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-danger">
                        @if ($post->id == $thread->posts[0]->id)
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