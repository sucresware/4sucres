@extends('layouts.app')

@section('title')
    Autorisation OAuth
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    Demande d'autorisation OAuth
                </div>
                <div class="card-body">
                    <!-- Introduction -->
                    <p><strong>{{ $client->name }}</strong> demande la permission d'accéder à votre compte.</p>

                    <!-- Scope List -->
                    @if (count($scopes) > 0)
                        <div class="scopes">
                                <p><strong>Cette application sera capable de :</strong></p>

                                <ul>
                                    @foreach ($scopes as $scope)
                                        <li>{{ $scope->description }}</li>
                                    @endforeach
                                </ul>
                        </div>
                    @endif
                </div>
                <div class="card-footer text-right">
                        <form class="d-inline" method="post" action="{{ route('passport.authorizations.deny') }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <input type="hidden" name="state" value="{{ $request->state }}">
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <button class="btn btn-secondary">Annuler</button>
                        </form>

                        <form class="d-inline" method="post" action="{{ route('passport.authorizations.approve') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="state" value="{{ $request->state }}">
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <button type="submit" class="btn btn-primary ladda-button">Autoriser</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection