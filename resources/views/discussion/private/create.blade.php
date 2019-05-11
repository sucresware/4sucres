@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ url('/css/sceditor.css') }}">
@endpush

@section('title')
    Nouveau message privé pour {{ $to->name }}
@endsection

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
                    <button class="btn btn-secondary" data-action="openPreview" data-toggle="modal" data-target="#preview">Vérifier ma connerie</button>
                    <button type="submit" class="btn btn-primary">Ouvrir le débat</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
