@extends('layouts.app')

@section('title')
    Modification du profil
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <form method="POST" action="{{ route('user.update', [$user->id, $user->name]) }}" enctype='multipart/form-data'>
                    <div class="card-body">
                        <h1 class="h6">Modification du profil</h1>
                        @method('put')
                        @csrf

                        {!! BootForm::file('avatar', 'Photo de profil') !!}
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
