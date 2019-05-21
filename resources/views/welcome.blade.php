@extends('layouts.app')

@section('title')
    Bienvenue sur le forum 4sucres.org
@endsection

@section('main')
    <div class="mb-4">
        <img src="{{ url('/img/banners/wip.jpg') }}" class="img-fluid shadow-sm">
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-3 col-xl-2 mb-3 @if (auth()->check() && user()->getSetting('layout.sidebar', 'left') == 'right') order-md-2 @endif">
            <div class="mb-3">
                @auth
                    @can('create discussions')
                        @php $link = route('discussions.create'); $label = '<i class="fas fa-plus mr-1"></i>Nouvelle discussion'; @endphp
                    @endcan
                @else
                    @php $link = route('register'); $label = '<i class="fas fa-user-plus mr-1"></i> Rejoins-nous !'; @endphp
                @endauth
                <a href="{!! $link !!}" class="btn btn-primary shadow btn-block">{!! $label !!}</a>
            </div>

            <div class="d-none d-lg-block">
                <hr class="ml-2">
                <div class="nav flex-column nav-pills">
                    <a href="{{ route('discussions.index') }}" class="nav-link {{ active(['discussions.index']) . active(['home']) }}">Tout voir</a>
                    @auth
                        <a href="{{ route('discussions.subscriptions') }}" class="nav-link {{ active(['discussions.subscriptions']) }}">Mes abonnements</a>
                    @endauth
                </div>
                <hr>
                <h5 class="mt-0 mb-2 ml-2">Catégories</h5>
                <div class="nav flex-column nav-pills">
                    @foreach ($categories as $category)
                        <a href="{{ route('discussions.categories.index', [$category->id, $category->slug]) }}" class="nav-link {{ active([route('discussions.categories.index', [$category->id, $category->slug])]) }}" style="color: {{ $category->color }}"><i class="fas fa-hashtag"></i> {{ ltrim($category->name, '#') }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-9 col-xl-10">
            @if (isset($sticky_discussions) && count($sticky_discussions))
                <div class="card shadow-sm mb-3">
                    @foreach ($sticky_discussions as $discussion)
                        <div class="{{ $loop->index%2 ? 'white' : 'blue' }}">
                            <div class="p-3">
                                @include('discussion._small_preview')
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if (isset($discussions) && count($discussions))
                <div class="card shadow-sm mb-3">
                    @forelse ($discussions as $discussion)
                        <div class="{{ $loop->index%2 ? 'white' : 'blue' }}">
                            @include('discussion._preview')
                        </div>
                    @empty
                    @endforelse
                </div>
            @endif

            @if (count($sticky_discussions) + count($discussions) == 0)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="text-center text-muted">
                            <img src="{{ url('svg/sucre_sad.svg') }}" class="img-fluid" width="60px"><br><br>
                            Aucune discussion dans cette catégorie !
                        </div>
                    </div>
                </div>
            @endif

            {{ $discussions->onEachSide(1)->links() }}
        </div>
    </div>
</div>
@endsection
