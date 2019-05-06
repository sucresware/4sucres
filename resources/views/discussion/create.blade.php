@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/sceditor/2.1.2/themes/default.min.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('discussions.store') }}" method="post">
                @csrf
                {!! BootForm::text('title', 'Sujet') !!}
                {!! BootForm::textarea('body', 'Message', old('body'), ['class' => 'form-control', 'style' => 'width: 100%;']) !!}

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Créer</button>
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