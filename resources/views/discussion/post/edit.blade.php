@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ url('/css/sceditor.css') }}">
@endpush

@section('title')
    Modification d'un message
@endsection

@section('content')
<div class="container">
    @if ($discussion->user_id == auth()->user()->id || auth()->user()->can('bypass discussions guard'))
        <div class="card mb-3">
            <form action="{{ route('discussions.update', [$discussion->id, $discussion->slug]) }}" method="post">
                <div class="card-body">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-8">
                            {!! BootForm::text('title', 'Sujet', old('title', $discussion->title)) !!}
                        </div>
                        <div class="col-md-4">
                            {!! BootForm::select('category', 'Catégorie', $categories, old('categories', $discussion->category_id)) !!}
                        </div>
                    </div>

                    @can('bypass discussions guard')
                        <div class="bg-light border rounded px-3 pt-3 pb-0">
                            {!! BootForm::checkbox('sticky', 'Épingler cette discussion', 1, $discussion->sticky) !!}
                            {!! BootForm::checkbox('locked', 'Verrouiller cette discussion', 1, $discussion->locked) !!}
                        </div>
                    @endcan
                </div>
                <div class="card-footer bg-light">
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <div class="card">
        <form action="{{ route('discussions.posts.update', [$discussion->id, $discussion->slug, $post->id]) }}" method="post">
            <div class="card-body">
                @csrf
                @method('put')
                @include('includes/_editor', ['name' => 'body', 'value' => old('body', $post->body)])
            </div>
            <div class="card-footer bg-light">
                <div class="text-right">
                    <a href="{{ route('discussions.show', [$discussion->id, $discussion->slug]) }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Oupsi la faute de frappe</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection