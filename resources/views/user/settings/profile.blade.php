@extends('layouts.app')

@section('title')
    Paramètres
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-3 col-xl-2 mb-3">
            @include('user.settings._navigation')
        </div>
        <div class="col-lg-7 col-xl-8">
            <form method="POST" action="{{ route('user.settings.profile', $user->name) }}" enctype='multipart/form-data' id="settings">
                @method('put')
                @csrf

                <div class="card mb-3">
                    <div class="card-header">
                        Modification du profil
                    </div>
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto pr-3 d-none d-md-flex">
                                <img src="{{ $user->avatar_link }}" class="img-fluid rounded" style="max-height: 60px;">
                            </div>
                            <div class="col">
                                <div class="form-group mb-3 {{ $errors->has('avatar') ? 'is-invalid' : '' }}">
                                    <label for="avatar" class="col-form-label {{ $errors->has('avatar') ? 'text-danger' : '' }}">Photo de profil</label>
                                    <div class="custom-file {{ $errors->has('avatar') ? 'is-invalid' : '' }}">
                                        <input type="file" class="custom-file-input {{ $errors->has('avatar') ? 'is-invalid' : '' }}" id="avatar" name="avatar">
                                        <label class="custom-file-label" for="customFile" data-browse="Choisir un fichier">Aucun fichier choisi</label>
                                        @if ($errors->has('avatar'))
                                            <div class="invalid-feedback">{{ $errors->first('avatar') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! BootForm::text('display_name', 'Nom d\'affichage*', old('display_name', $user->display_name)) !!}

                        @can('update shown_role')
                            {!! BootForm::text('shown_role', 'Classification', old('shown_role', $user->shown_role)) !!}
                        @endcan

                        @can('update achievements')
                            {!! BootForm::select('achievements[]', 'Succès', $achievements, old('achievements[]', $user->achievements->pluck('id')), ['class' => 'select2', 'multiple']) !!}
                        @endcan

                        @can('update roles')
                            {!! BootForm::select('role', 'Rôle', $roles, old('role', $user->roles[0]->id), ['class' => 'select2']) !!}
                        @endcan
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
