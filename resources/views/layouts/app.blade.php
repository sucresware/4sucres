<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection ('title')
            @yield('title') - 4SUCRES.org
        @else
            4SUCRES.org
        @endif
    </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body>
    <div id="app">
        <div class="sticky-top">
            <nav class="navbar navbar-expand-md navbar-dark bg-darker">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ url('/svg/4sucres.svg') }}" height="60"> 4SUCRES<small>.org</small>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('discussions.index') }}"><i class="fas fa-home"></i> Forum</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('leaderboard') }}"><i class="fas fa-clipboard"></i> Classement</a>
                            </li>
                        </ul>

                        <ul class="navbar-nav ml-auto">
                            @guest
                                <div class="row no-gutters account-block mb-3 mb-md-0">
                                    <div class="col account-details bg-darker rounded text-md-right">
                                        <span class="account-username">Sucre égaré</span><br>
                                        <a href="{{ route('register') }}" class="mr-1"><i class="fas fa-user-plus"></i> Inscription</a>
                                        <a href="{{ route('login') }}"><i class="fas fa-power-off"></i> Connexion</a>
                                    </div>
                                    <div class="col-auto account-image rounded">
                                        <img src="{{ url('/img/guest.png') }}" class="img-fluid">
                                    </div>
                                </div>
                            @else
                                <div class="row no-gutters account-block mb-3 mb-md-0">
                                    <div class="col account-details bg-darker rounded text-md-right">
                                        <a href="{{ route('profile') }}">
                                            <span class="account-username" >{{ auth()->user()->display_name }}</span>
                                        </a>
                                        <br>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-power-off mr-1"></i> Déconnexion</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                    </div>
                                    <div class="col-auto account-image rounded">
                                        <img src="{{ url('/img/guest.png') }}" class="img-fluid">
                                    </div>
                                </div>
                            @endguest
                        </ul>
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
            {{ \Tremby\LaravelGitVersion\GitVersionHelper::getVersion() }}<br>
            <a href="{{ route('terms') }}">Conditions générales d'utilisation</a> - <a href="{{ route('charte') }}">Charte d'utilisation</a>
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
    @stack('js')
</body>
</html>
