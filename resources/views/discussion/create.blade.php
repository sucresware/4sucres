@extends('layouts.app')

@section('title')
    Nouvelle discussion
@endsection

@section('content')
<div class="container">
    <div class="card">
        <form action="{{ route('discussions.store') }}" method="post" data-disable-on-submit>
            <div class="card-body">
                <h1 class="h6">Nouvelle discussion</h1>
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        {!! BootForm::text('title', 'Sujet') !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::select('category', 'Catégorie', $categories) !!}
                    </div>
                </div>
                @include('includes/_editor', ['name' => 'body', 'value' => old('body')])
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <button class="btn btn-secondary" data-action="open-preview" data-toggle="modal" data-target="#preview">Vérifier ma connerie</button>
                    <button type="submit" class="btn btn-primary">Ouvrir le débat</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection