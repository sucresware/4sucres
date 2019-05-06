@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/sceditor/2.1.2/themes/default.min.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('discussions.posts.update', [$discussion->id, $discussion->slug, $post->id]) }}" method="post">
                @csrf
                @method('put')
                {!! BootForm::textarea('body', 'Message', old('body', $post->body), ['class' => 'form-control', 'style' => 'width: 100%;']) !!}

                <div class="text-right">
                    <a href="{{ route('discussions.show', [$discussion->id, $discussion->slug]) }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
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