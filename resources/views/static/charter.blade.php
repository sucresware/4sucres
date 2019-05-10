@extends('layouts.app')

@section('title')
    Charte d'utilisation
@endsection

@section('content')

<div class="container">
    <div class="card">
        <div class="card-body">
            @php
                echo Cache::remember('charter_md', now()->addHour(1), function () {
                    $content = File::get(base_path('resources/views/static/markdown/charter.md'));
                    return (new Parsedown())->text($content);
                });
            @endphp
        </div>
    </div>
</div>

@endsection
