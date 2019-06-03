@extends('layouts.app')

@section('title')
    Suppression de l'utilisateur {{ $user->name }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <form method="POST" action="{{ route('user.destroy', [$user->name]) }}" enctype='multipart/form-data'>
                    <div class="card-body">
                        <h1 class="text-danger h6">Suppression</h1>
                        <p>Tu veux vraiment faire disparaitre {{ $user->name }} ?</p>

                        @method('delete')
                        @csrf


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
