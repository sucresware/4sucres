@extends('layouts.app')

@section('title')
Modification d'un message
@endsection

@section('content')
<div class="container">
    @if ($thread->user_id == user()->id || user()->can('bypass threads guard'))
    <div class="card mb-3">
        <form action="{{ route('threads.update', [$thread->id, $thread->slug]) }}" method="post">
            <div class="card-body">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-8">
                        @include('components.form.input', [
                        'type' => 'text',
                        'name' => 'title',
                        'label' => 'Sujet',
                        'value' => $thread->title,
                        'required' => true,
                        ])
                    </div>
                    <div class="col-md-4">
                        @php
                        $disabled = (bool) ($thread->board_id == \App\Models\Board::CATEGORY_SHITPOST &&
                        !user()->can('bypass threads guard'));
                        @endphp

                        @include('components.form.select', [
                        'name' => 'board',
                        'label' => 'Catégorie',
                        'options' => $boards,
                        'value' => $thread->board_id,
                        'required' => true,
                        'disabled' => $disabled,
                        ])
                    </div>
                </div>

                @can('bypass threads guard')
                <div class="card">
                    <div class="card-body pb-0">
                        @include('components.form.checkbox', [
                        'name' => 'sticky',
                        'label' => 'Épingler cette thread',
                        'value' => 1,
                        'default' => $thread->sticky,
                        ])

                        @include('components.form.checkbox', [
                        'name' => 'locked',
                        'label' => 'Verrouiller cette thread',
                        'value' => 1,
                        'default' => $thread->locked,
                        ])
                    </div>
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
        <form action="{{ route('threads.posts.update', [$thread->id, $thread->slug, $post->id]) }}" method="post">
            <div class="card-body">
                @csrf
                @method('put')
                @include('includes/_editor', ['name' => 'body', 'value' => old('body', $post->body)])
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <a href="{{ route('threads.show', [$thread->id, $thread->slug]) }}"
                        class="btn btn-outline-secondary">Annuler</a>
                    <button class="btn btn-secondary" data-action="open-preview" data-toggle="modal"
                        data-target="#preview">Vérifier ma connerie</button>
                    <button type="submit" class="btn btn-primary">Oupsi la faute de frappe</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection