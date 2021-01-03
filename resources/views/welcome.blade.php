@extends('layouts.app')

@section('title')
Bienvenue sur le forum 4sucres.org
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div
            class="col-12 col-lg-3 col-xl-2 mb-3 @if (auth()->check() && user()->getSetting('layout.sidebar', 'left') == 'right') order-md-2 @endif">
            <div class="mb-3">
                @auth
                @can('create threads')
                @php $link = route('threads.create'); $label = '<i class="mr-1 fas fa-plus"></i>Nouvelle thread';
                @endphp
                @endcan
                @else
                @php $link = route('register'); $label = '<i class="mr-1 fas fa-user-plus"></i> Rejoins-nous !'; @endphp
                @endauth

            </div>

            <div class="d-none d-lg-block">
                <hr>
                <div class="nav flex-column nav-pills">
                    <a href="{{ route('threads.index') }}"
                        class="nav-link {{ $all = active(['threads.index']) . active(['home']) }}">Tout voir</a>
                    @auth
                    <a href="{{ route('threads.subscriptions') }}"
                        class="nav-link {{ active(['threads.subscriptions']) }}">Mes abonnements</a>
                    @endauth
                </div>
                <hr>
                <h5 class="mt-0 mb-2 ml-2">Catégories</h5>
                <div class="nav flex-column nav-pills">
                    @foreach ($boards as $board)
                    <a href="{{ route('threads.boards.index', [$board->id, $board->slug]) }}"
                        class="nav-link {{ active([route('threads.boards.index', [$board->id, $board->slug])]) }}"
                        style="color: {{ $board->color }}"><i class="fas fa-hashtag"></i>
                        {{ ltrim($board->name, '#') }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-9 col-xl-10">
            @if ($all)
            @php $countTo = carbon('2020-01-01 00:00:00'); @endphp
            @if (now()->lte($countTo))
            <div class="mb-3 countdown w-100">
                <div class="squares"></div>
                <div class="row justify-content-center">
                    <div class="block py-3 d-none d-sm-inline-block">
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
                {{-- <div><img src="{{ url('/img/banners/new_year.jpg') }}" class="shadow img-fluid"></div> --}}
            <div><img src="{{ url('/img/banners/release.jpg') }}" class="shadow img-fluid"></div>
            <div><img src="{{ url('/img/banners/welcome.jpg') }}" class="shadow img-fluid"></div>
            {{-- <div><img src="{{ url('/img/banners/natives.jpg') }}" class="shadow img-fluid">
        </div> --}}
        {{-- <div><img src="{{ url('/img/banners/beta.jpg') }}" class="shadow img-fluid">
    </div> --}}
    {{-- <div><img src="{{ url('/img/banners/alpha.jpg') }}" class="shadow img-fluid">
</div> --}}
</div>
@endif
@endif

<section class="mb-3 shadow-sm card thread-previews">
    @if (isset($sticky_threads) && count($sticky_threads))
    @foreach ($sticky_threads as $thread)
    @endforeach
    @endif

    @if (isset($threads) && count($threads))
    @foreach ($threads as $thread)

    @endforeach
    @endif

    @if (count($sticky_threads) + count($threads) == 0)
    <div class="card-body">
        <div class="text-center text-muted">
            <img src="{{ url('svg/sucre_sad.svg') }}" class="img-fluid" width="60px"><br><br>
            Aucune thread dans cette catégorie !
        </div>
    </div>
    @endif
</section>

{{ $threads->onEachSide(1)->links() }}
</div>
</div>
</div>
@endsection