@extends('layouts.app')

@section('title')
Nouvelle thread
@endsection

@section('content')
<div class="container">
    <div class="card">
        <form action="{{ route('threads.store') }}" method="post">
            <div class="card-body">
                <h1 class="h6">Nouvelle thread</h1>
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        @include('components.form.input', [
                        'type' => 'text',
                        'name' => 'title',
                        'label' => 'Sujet',
                        'required' => true,
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('components.form.select', [
                        'name' => 'board',
                        'label' => 'Catégorie',
                        'options' => $boards,
                        'required' => true,
                        ])
                    </div>
                </div>
                @include('includes/_editor', ['name' => 'body', 'value' => old('body')])
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <button class="btn btn-secondary" data-action="open-preview" data-toggle="modal"
                        data-target="#preview">Vérifier ma connerie</button>
                    <button type="submit" class="btn btn-primary">Ouvrir le débat</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection