@extends('layouts.app')

@section('title')
    Paramètres
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <form method="POST" action="{{ route('user.settings', []) }}" enctype='multipart/form-data'>
                    <div class="card-body">
                        <h1 class="h6">Paramètres</h1>
                        @method('put')
                        @csrf

                        {!! BootForm::checkbox('layout_sidebar_right', 'Déplacer la sidebar à droite', 1, old('layout_sidebar_right', $user->getSetting('layout.sidebar.right', false))) !!}
                        {!! BootForm::checkbox('layout_stickers_inline', 'Adapter la taille des stickers au texte', 1, old('layout_stickers_inline', $user->getSetting('layout.stickers.inline', false))) !!}
                    </div>

                    <div class="card-footer bg-light">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
