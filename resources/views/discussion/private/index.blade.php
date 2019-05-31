@extends('layouts.app')

@section('title')
    Messagerie privée
@endsection

@section('content')
<div class="container">
    <h1>Messagerie privée</h1>

    <div class="card">
        @forelse ($private_discussions as $discussion)
            <section class="dicussion-preview">
                @include('discussion._preview')
            </section>
        @empty
            <div class="card-body">
                <div class="text-center text-muted">
                    <img src="{{ url('svg/sucre_sad.svg') }}" class="img-fluid" width="100px"><br><br>
                    Aucune message privé !
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection