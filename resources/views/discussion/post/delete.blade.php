@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <form action="{{ route('discussions.posts.destroy', [$discussion->id, $discussion->slug, $post->id]) }}" method="post">
            <div class="card-body">
                // TODO
                @csrf
                @method('delete')
            </div>
            <div class="card-footer bg-light">
                <div class="text-right">
                    <a href="{{ route('discussions.show', [$discussion->id, $discussion->slug]) }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-danger">Ça dégage</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
