@extends('layouts.app')

@section('title')
    Notifications
@endsection

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h1>Notifications</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('notifications.clear') }}" class="btn btn-outline-primary">Tout marquer comme lu</a>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            @forelse ($notifications as $notification)
                <a href="{{ route('notifications.show', $notification) }}">{!! $notification->data['text'] !!}</a> {{ $notification->created_at->diffForHumans() }}<br>
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