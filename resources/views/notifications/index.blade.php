@extends('layouts.app')

@section('title')
    Notifications
@endsection

@section('content')
<div class="container">
    <h1>Notifications</h1>

    <div class="card">
        <div class="card-body">
            @forelse ($notifications as $notification)
                <strong><a href="{{ route('notifications.show', $notification) }}">{{ $notification->text }}</a></strong><br>
            @empty
                <div class="text-center text-muted">
                    <img src="{{ url('svg/sucre_sad.svg') }}" class="img-fluid" width="100px"><br><br>
                    Aucune nouvelle notification !
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection