@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ url('/css/sceditor.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="card">
        <form action="{{ route('private_discussions.store', [$to->id, $to->name]) }}" method="post">
            <div class="card-body">
                <h1 class="h6">Nouveau message privé pour {{ $to->name }}</h1>
                @csrf
                {!! GoogleReCaptchaV3::renderField('create_private_discussion_id', 'create_private_discussion_action') !!}

                {!! BootForm::text('title', 'Sujet') !!}
                @include('includes/_editor', ['name' => 'body', 'value' => old('body')])
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
