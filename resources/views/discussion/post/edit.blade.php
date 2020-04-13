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
                            @include('components.form.input', [
                                'type' => 'text',
                                'name' => 'title',
                                'label' => 'Sujet',
                                'value' => $discussion->title,
                                'required' => true,
                            ])
                        </div>
                        <div class="col-md-4">
                            @php
                                $disabled = (bool) ($discussion->category_id == \App\Models\Category::CATEGORY_SHITPOST && !user()->can('bypass discussions guard'));
                            @endphp

                            @include('components.form.select', [
                                'name' => 'category',
                                'label' => 'Catégorie',
                                'options' => $categories,
                                'value' => $discussion->category_id,
                                'required' => true,
                                'disabled' => $disabled,
                            ])
                        </div>
                    </div>

                    @can('bypass discussions guard')
                        <div class="card">
                            <div class="card-body pb-0">
                                @include('components.form.checkbox', [
                                    'name' => 'sticky',
                                    'label' => 'Épingler cette discussion',
                                    'value' => 1,
                                    'default' => $discussion->sticky,
                                ])

                                @include('components.form.checkbox', [
                                    'name' => 'locked',
                                    'label' => 'Verrouiller cette discussion',
                                    'value' => 1,
                                    'default' => $discussion->locked,
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