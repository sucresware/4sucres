@extends('layouts.admin')

@section('title')
    Activité
@endsection

@section('content')
    <activities :initial-paginator="{{ $activities->toJson() }}"></activities>

    {{ $activities->onEachSide(1)->links() }}
@endsection