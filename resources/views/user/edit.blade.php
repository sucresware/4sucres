@extends('layouts.app')

@section('title')
    Modification du profil
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <form method="POST" action="{{ route('user.update', [$user->name]) }}" enctype='multipart/form-data'>
                    <div class="card-body">
                        <h1 class="h6">Modification du profil</h1>
                        @method('put')
                        @csrf

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

                    <div class="card-footer">
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
