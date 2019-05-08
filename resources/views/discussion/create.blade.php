@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ url('/css/sceditor.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="card">
        <form action="{{ route('discussions.store') }}" method="post">
            <div class="card-body">
                <h1 class="h6">Nouvelle discussion</h1>
                @csrf
                {!! GoogleReCaptchaV3::renderField('create_discussion_id', 'create_discussion_action') !!}

                <div class="row">
                    <div class="col-md-8">
                        {!! BootForm::text('title', 'Sujet') !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::select('category', 'Catégorie', $categories) !!}
                    </div>
                </div>
                {!! BootForm::textarea('body', 'Message', old('body'), ['style' => 'width: 100%;']) !!}
            </div>
            <div class="card-footer bg-light">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Créer la discussion</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script> init_editor(document.getElementById('body')); </script>
@endpush