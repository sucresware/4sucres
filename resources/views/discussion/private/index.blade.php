@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Messagerie privée</h1>

    <div class="card">
        @foreach ($private_discussions as $discussion)
            <div class="{{ $loop->index%2 ? 'white' : 'blue' }}">
                <div class="p-3">
                    @include('discussion._preview')
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection