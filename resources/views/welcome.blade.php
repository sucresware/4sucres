@extends('layouts.app')

@section('title')
    Bienvenue sur le forum 4sucres.org
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
                <hr>
                <div class="nav flex-column nav-pills">
                    <a href="{{ route('discussions.index') }}" class="nav-link {{ $all = active(['discussions.index']) . active(['home']) }}">Tout voir</a>
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
            @if ($all)
                @php $countTo = carbon('2020-01-01 00:00:00'); @endphp
                @if (now()->lte($countTo))
                    <div class="countdown w-100 mb-3">
                        <div class="squares"></div>
                        <div class="row justify-content-center">
                            <div class="block d-none d-sm-inline-block py-3">
                                <img src="/img/banners/countdown/logo.png" alt="4sucres" style="height: 100%;">
                            </div>
                            <div class="block">
                                <span class="timer">
                                    <span class="dimmed">000000</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="owl-carousel d-none d-md-block">
                        {{-- <div><img src="{{ url('/img/banners/new_year.jpg') }}" class="img-fluid shadow"></div> --}}
                        <div><img src="{{ url('/img/banners/release.png') }}" class="img-fluid shadow"></div>
                        <div><img src="{{ url('/img/banners/welcome.jpg') }}" class="img-fluid shadow"></div>
                        {{-- <div><img src="{{ url('/img/banners/natives.jpg') }}" class="img-fluid shadow"></div> --}}
                        {{-- <div><img src="{{ url('/img/banners/beta.jpg') }}" class="img-fluid shadow"></div> --}}
                        {{-- <div><img src="{{ url('/img/banners/alpha.jpg') }}" class="img-fluid shadow"></div> --}}
                    </div>
                @endif
            @endif

            <section class="card shadow-sm mb-3 discussion-previews">
                @if (isset($sticky_discussions) && count($sticky_discussions))
                    @foreach ($sticky_discussions as $discussion)
                        <div class="discussion-preview">
                            @include('discussion._preview')
                        </div>
                    @endforeach
                @endif

                @if (isset($discussions) && count($discussions))
                    @foreach ($discussions as $discussion)
                        <div class="discussion-preview">
                            @include('discussion._preview')
                        </div>
                    @endforeach
                @endif

                @if (count($sticky_discussions) + count($discussions) == 0)
                    <div class="card-body">
                        <div class="text-center text-muted">
                            <img src="{{ url('svg/sucre_sad.svg') }}" class="img-fluid" width="60px"><br><br>
                            Aucune discussion dans cette catégorie !
                        </div>
                    </div>
                @endif
            </section>

            {{ $discussions->onEachSide(1)->links() }}
        </div>
    </div>
</div>
@endsection