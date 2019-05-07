<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection ('title')
            @yield('title') - 4sucres.org
        @else
            4sucres.org
        @endif
    </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
    <meta name="application-name" content="4sucres.org"/>
    <meta name="msapplication-TileColor" content="#213345" />
    <meta name="msapplication-TileImage" content="mstile-144x144.png" />

    @stack('css')
</head>
<body>
    <div id="app">
        <div class="sticky-top">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ url('/svg/4sucres.svg') }}" height="60"><img src="{{ url('/img/4sucres_white.png') }}" height="30">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link text-center" href="{{ route('discussions.index') }}"><i class="fas fa-home"></i><span class="d-md-none d-lg-block"> Forum</span></a>
                            </li>
                            {{--  <li class="nav-item">
                                <a class="nav-link text-center" href="{{ route('leaderboard') }}"><i class="fas fa-clipboard"></i><span class="d-md-none d-lg-block"> Classement</span></a>
                            </li>  --}}
                        </ul>

                        @auth
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link text-center" href="{{ route('notifications.index') }}">
                                        @if ($notifications_count = \App\Models\Notification::curated()->count())
                                            <i class="fas fa-bell text-danger"></i>
                                        @else
                                            <i class="fas fa-bell"></i>
                                        @endif
                                        <span class="d-md-none d-lg-block"> Notifications</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-center" href="{{ route('private_discussions.index') }}">
                                        <i class="fas fa-envelope"></i>
                                        <span class="d-md-none d-lg-block"> Messagerie</span>
                                    </a>
                                </li>
                            </ul>
                        @endauth

                        @guest
                            <div class="row no-gutters account-block mb-3 mb-md-0">
                                <div class="col account-details bg-darker rounded text-md-right text-center text-md-left">
                                    <a href="{{ route('register') }}" class="mr-1"><i class="fas fa-user-plus"></i> Inscription</a>
                                    <a href="{{ route('login') }}"><i class="fas fa-power-off"></i> Connexion</a>
                                </div>
                            </div>
                        @else
                            <div class="row no-gutters account-block mb-3 mb-md-0">
                                <div class="col account-details bg-darker rounded text-md-right">
                                    <span class="account-username">
                                        <a href="{{ route('profile') }}">{{ auth()->user()->display_name }}</a>
                                    </span>
                                    <br>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-power-off mr-1"></i> Déconnexion</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                </div>
                                <div class="col-auto account-image rounded">
                                    <img src="{{ auth()->user()->avatar ? url('storage/avatars/' . auth()->user()->avatar) : url('/img/guest.png') }}" class="img-fluid">
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </nav>
        </div>

        <main class="py-4">
            @yield('content')
        </main>

        <footer>
            <img src="{{ url('/img/4sucres_alt_glitched.png') }}" width="70px">
            &copy; 2019<br>
            <br>
            <strong>4sucres.org</strong>, parce que 2 c'étais pas assez.<br>
            <a href="{{ route('terms') }}">Conditions générales d'utilisation</a> - <a href="{{ route('charter') }}">Charte d'utilisation</a>
        </footer>
    </div>

    @if (session('success'))
        @php alert()->success(null, session('success'))->persistent(); @endphp
    @endif

    @if (session('info'))
        @php alert()->info(null, session('info'))->persistent(); @endphp
    @endif

    @if (session('error'))
        @php alert()->error(null, session('error'))->persistent(); @endphp
    @endif

    @include('sweetalert::alert')

    {!! GoogleReCaptchaV3::init() !!}
    <script src="{{ url('https://code.jquery.com/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ url('https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('/js/baffle.min.js') }}"></script><script>
        var s=["█","▓","▒","░","█","▓","▒","░","█","▓","▒","░","<",">","/"];
        baffle('.baffle', {characters:s}).reveal(1000);
    </script>
    @stack('js')
</body>
</html>
