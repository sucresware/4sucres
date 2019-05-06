@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-4 col-xl-2 mb-3">
            <div class="mb-3">
                @auth
                    @can('create discussions')
                        @php $link = route('discussions.create'); $label = '<i class="fas fa-plus mr-1"></i>Nouvelle discussion'; @endphp
                    @endcan
                @else
                    @php $link = route('register'); $label = '<i class="fas fa-user-plus mr-1"></i> Rejoins-nous !'; @endphp
                @endauth
                <img src="{{ url('/svg/sucre_onche.svg') }}" class="d-none d-xl-block mx-auto" height="150">
                <a href="{!! $link !!}" class="btn btn-primary btn-block d-none d-xl-block" style="padding-top: 40px; margin-top: -35px;">{!! $label !!}</a>
                <a href="{!! $link !!}" class="btn btn-primary btn-block d-xl-none">{!! $label !!}</a>
            </div>

            <div class="d-none d-lg-block">
                <hr class="ml-2">
                <h5 class="mt-0 mb-2 ml-2">Catégories</h5>
                <div class="nav flex-column nav-pills">
                    <a href="{{ route('discussions.index') }}" class="nav-link {{ active(['discussions.index']) . active(['home']) }}">Toutes</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('discussions.categories.index', [$category->id, $category->slug]) }}" class="nav-link {{ active([route('discussions.categories.index', [$category->id, $category->slug])]) }}" style="color: {{ $category->color }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 col-xl-10">
            <div class="mb-4">
                <img src="{{ url('/img/banner_special.png') }}" class="img-fluid">
            </div>

            <div class="card">
                @isset($sticky_discussions)
                    @foreach ($sticky_discussions as $discussion)
                        <div class="{{ $loop->index%2 ? 'white' : 'blue' }}">
                            <div class="p-3">
                                @include('discussion._preview')
                            </div>
                        </div>
                    @endforeach
                    <hr class="m-0">
                @endisset
                @foreach ($discussions as $discussion)
                    <div class="{{ $loop->index%2 ? 'white' : 'blue' }}">
                        <div class="p-3">
                            @include('discussion._preview')
                        </div>
                    </div>
                @endforeach

                {{ $discussions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
