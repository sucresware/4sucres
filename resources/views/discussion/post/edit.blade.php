@extends('layouts.app')

@section('title')
    Modification d'un message
@endsection

@section('content')
<div class="container">
    @if ($discussion->user_id == user()->id || user()->can('bypass discussions guard'))
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
                            @php
                                $disabled = ($discussion->category_id !== \App\Models\Category::SHITPOST_CATEGORY_ID || user()->can('bypass discussions guard')) ? '' : 'disabled';
                            @endphp
                            {!! BootForm::select('category', 'Catégorie', $categories, old('categories', $discussion->category_id), [$disabled]) !!}
                        </div>
                    </div>

                    @can('bypass discussions guard')
                        <div class="bg-light border rounded px-3 pt-3 pb-0">
                            {!! BootForm::checkbox('sticky', 'Épingler cette discussion', 1, $discussion->sticky) !!}
                            {!! BootForm::checkbox('locked', 'Verrouiller cette discussion', 1, $discussion->locked) !!}
                        </div>
                    @endcan
                </div>
                <div class="card-footer">
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
            <div class="card-footer">
                <div class="text-right">
                    <a href="{{ route('discussions.show', [$discussion->id, $discussion->slug]) }}" class="btn btn-outline-secondary">Annuler</a>
                    <button class="btn btn-secondary" data-action="open-preview" data-toggle="modal" data-target="#preview">Vérifier ma connerie</button>
                    <button type="submit" class="btn btn-primary">Oupsi la faute de frappe</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection