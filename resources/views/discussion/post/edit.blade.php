@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/sceditor/2.1.2/themes/default.min.css') }}">
@endpush

@section('content')
<div class="container">
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

                @can('moderate discussions')
                    <div class="bg-light border rounded px-3 pt-3 pb-0">
                        {!! BootForm::checkbox('sticky', 'Épingler cette discussion', 1, $discussion->sticky) !!}
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
    <script>
        var textarea = document.getElementById('body');
        sceditor.create(textarea, {
	        format: 'bbcode',
            emoticonsEnabled: false,
            resizeEnabled: false,
            width: '100%',
	        style: 'https://cdnjs.cloudflare.com/ajax/libs/sceditor/2.1.2/themes/content/default.min.css',
	        toolbar: 'bold,italic,underline,stroke|image,link|maximize,source',
       });
    </script>
@endpush