<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @auth
        <meta name="user-data" content="{{ json_encode(array_merge(user()->only(['id', 'name', 'email']), ['permissions' => user()->getPermissionsViaRoles()->pluck('name')])) }}" />
        <meta name="user-notification-count" content="{{ json_encode($notifications_count) }}" />
    @endauth

    <title>
        @hasSection ('title')
            @yield('title') - 4sucres.org
        @else
            4sucres.org
        @endif
    </title>
    <meta name="description" content="Et vous, combien de sucres vous prenez dans votre café ?">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{ mix('css/theme-dark.css') }}" rel="stylesheet">
    <!-- <link href="{{ mix('css/theme-light.css') }}" rel="stylesheet"> -->

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url('/img/icons/apple-touch-icon-144x144.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ url('/img/icons/apple-touch-icon-152x152.png') }}">
    <link rel="icon" type="image/png" href="{{ url('/img/icons/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ url('/img/icons/favicon-16x16.png') }}" sizes="16x16">
    <link rel="shortcut icon" href="{{ url('/img/icons/favicon.ico') }}">
    <meta name="application-name" content="4sucres">
    <meta name="theme-color" content="#3b4252">
    <meta name="msapplication-TileColor" content="#3b4252">
    <meta name="msapplication-TileImage" content="{{ url('/img/icons/mstile-144x144.png') }}">
    {!! NoCaptcha::renderJs('fr') !!}

    @if (config('app.env') === 'production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-139755516-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-139755516-1');
        </script>

        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-1896835277768477",
                enable_page_level_ads: true
            });
        </script>
    @endif

    @stack('css')
</head>
<body>
    <div id="app">
        <div class="sticky-top">
            <nav class="navbar navbar-expand-lg shadow">
                <div class="container justify-content-between">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ url('/svg/4sucres.svg') }}" height="35px" class="d-sm-none">
                        <img src="{{ url('/img/4sucres_white.png') }}" height="30px" class="d-none d-sm-inline-block">
                    </a>

                    @auth
                        <a class="ml-auto text-center mr-1 order-lg-7" href="{{ route('notifications.index') }}">
                            <span class="fa-stack notification" id="notifications_indicator">
                                <i class="fas fa-circle fa-stack-2x notification-background"></i>
                                @if ($notifications_count)
                                    <i class="fas fa-bell fa-stack-1x fa-inverse fa-sm notification-icon"></i>
                                    <span class="badge badge-danger badge-pill notification-counter">{{ $notifications_count }}</span>
                                @else
                                    <i class="fas fa-bell fa-stack-1x fa-sm notification-icon"></i>
                                @endif
                            </span>
                        </a>

                        <a class="text-center mr-1 order-lg-8" href="{{ route('private_discussions.index') }}">
                            <span class="fa-stack notification" id="private_discussions_indicator">
                                <i class="fas fa-circle fa-stack-2x notification-background"></i>
                                @if ($private_unread_count)
                                    <i class="fas fa-envelope fa-stack-1x fa-inverse fa-sm notification-icon"></i>
                                    <span class="badge badge-danger badge-pill notification-counter">{{ $private_unread_count }}</span>
                                @else
                                    <i class="fas fa-envelope fa-stack-1x fa-sm notification-icon"></i>
                                @endif
                            </span>
                        </a>

                        @if (user()->hasRole('admin') || user()->hasRole('moderator'))
                            <a class="text-center mr-1 order-lg-9" href="{{ route('admin.index') }}">
                                <span class="fa-stack notification">
                                    <i class="fas fa-circle fa-stack-2x notification-background"></i>
                                    <i class="fas fa-lock fa-stack-1x {{ (active('admin.*')) ? 'fa-inverse' : '' }} fa-sm notification-icon"></i>
                                </span>
                            </a>
                        @endif
                    @endauth

                    <a href="#" class="d-block d-lg-none" data-toggle="collapse" data-target="#navbarSupportedContent">
                        <span class="fa-stack">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-bars fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>

                    <div class="collapse navbar-collapse my-3 my-lg-3" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <form id="search" action="{{ route('search.query') }}">
                                    <div class="input-group mb-0">
                                        <input type="text" name="query" class="form-control input-header" value="{{ $query ?? null }}">
                                        <input type="hidden" name="scope" value="{{ $scope ?? 'posts' }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="d-inline btn btn-darker"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </li>
                            {{--  <li class="nav-item">
                                <a class="nav-link text-center" href="{{ route('discussions.index') }}"><i class="fas fa-home"></i><span class="d-lg-none d-lg-block"> Forum</span></a>
                            </li>  --}}
                            {{--  <li class="nav-item">
                                <a class="nav-link text-center" href="{{ route('leaderboard') }}"><i class="fas fa-clipboard"></i><span class="d-lg-none d-lg-block"> Classement</span></a>
                            </li> --}}
                        </ul>
                    </div>

                    <div class="collapse navbar-collapse flex-grow-0 order-lg-10 pl-lg-2" id="navbarSupportedContent">
                        @guest
                            <div class="row no-gutters account-block mb-3 mb-lg-0">
                                <div class="col account-details rounded text-lg-right text-center text-lg-left">
                                    <a href="{{ route('register') }}" class="mr-1"><i class="fas fa-user-plus mr-2"></i>Inscription</a>
                                    <a href="{{ route('login') }}"><i class="fas fa-power-off mr-2"></i>Connexion</a>
                                </div>
                            </div>
                        @else
                            <div class="row no-gutters account-block mb-3 mb-lg-0">
                                <div class="col account-details rounded text-lg-right">
                                    <span class="account-username">
                                        <a href="{{ route('profile') }}">{{ user()->display_name }}</a>
                                    </span>
                                    <br>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-power-off mr-2"></i>Déconnexion</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                </div>
                                <div class="col-auto account-image">
                                    <img src="{{ user()->avatar ? url('storage/avatars/' . user()->avatar) : url('/img/guest.png') }}" class="img-fluid rounded">
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </nav>
        </div>

        {{--  <div class="shadow">
            <div class="container text-white py-2">
                <div class="row justify-content-between font-small">
                    <div class="col-auto">
                    </div>
                    <div class="col-auto">
                        <small><i class="fas fa-circle text-success mr-1"></i><span class="presence-counter">{{ $presence_counter }}</span> <span class="d-none d-lg-inline-block">{{ str_plural('utilisateur', $presence_counter) }} {{str_plural('actif', $presence_counter)}}</span></small>
                    </div>
                </div>
            </div>
        </div>  --}}

        @if (auth()->check() && user()->restricted)
            <div class="shadow">
                <div class="container text-white py-2">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto mr-2"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="col">
                            <strong>Compte limité</strong><br>
                            @if($remains = user()->restricted_posts_remaining)
                                Ne t'inquiètes pas mon ami, tu peux profiter du forum en attendant de recevoir ton email de vérification ({{ user()->restricted_posts_remaining }} réponse(s) restante(s))
                            @else
                                Tu dois maintenant vérifier ton adresse email pour continuer !
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{--  @yield('main')  --}}

        @if (session('success'))
            <div class="alert alert-success shadow">
                <div class="container">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto mr-2"><i class="fas fa-check-circle"></i></div>
                        <div class="col">
                            {!! session('success') !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info shadow">
                <div class="container">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto mr-2"><i class="fas fa-info-triangle"></i></div>
                        <div class="col">
                            {!! session('info') !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger shadow">
                <div class="container">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto mr-2"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="col">
                            {!! session('error') !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>

        <footer>
            <img src="{{ url('/img/4sucres_alt_glitched.png') }}" width="70px">
            &copy; 2019<br>
            <br>
            <strong>4sucres.org</strong>, parce qu'à 2 on était pas assez.<br>
            <a href="{{ route('terms') }}">Conditions générales d'utilisation</a> <span class="mx-1">&mdash;</span>
            <a href="{{ route('charter') }}">Charte d'utilisation</a> <span class="mx-1">&mdash;</span>
            <a href="https://github.com/4sucres/board" target="_blank">GitHub</a>
        </footer>
    </div>

    @if (session('swal-success'))
        @php alert()->success(null, session('swal-success'))->persistent(); @endphp
    @endif

    @if (session('swal-info'))
        @php alert()->info(null, session('swal-info'))->persistent(); @endphp
    @endif

    @if (session('swal-error'))
        @php alert()->error(null, session('swal-error'))->persistent(); @endphp
    @endif

    @include('sweetalert::alert')

    @routes
    <script src="{{ mix('/js/app.js') }}"></script>
    @stack('js')
</body>
</html>
