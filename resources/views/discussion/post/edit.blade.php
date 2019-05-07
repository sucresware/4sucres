@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ url('/css/sceditor.css') }}">
@endpush

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
                {!! BootForm::textarea('body', 'Message', old('body', $post->body), ['class' => 'form-control', 'style' => 'width: 100%;']) !!}
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

@push('js')
    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/sceditor/2.1.2/sceditor.min.js') }}"></script>
    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/sceditor/2.1.2/formats/bbcode.js') }}"></script>
    <script> init_editor(document.getElementById('body')); </script>
@endpush