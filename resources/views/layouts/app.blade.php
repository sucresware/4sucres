<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection ('title')
            @yield('title') - 4Sucres
        @else
            4Sucres
        @endif
    </title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{--  <img src="{{ url('/svg/4sucres.svg') }}" class="logo-4s">  --}}
                    <div class="logo-4s"></div>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Forum</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Classement</a>
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
                                    <span class="account-username">{{ auth()->user()->display_name }}</span><br>
                                    <a href="{{ route('register') }}" class="mr-1"><i class="fas fa-user"></i> Profil</a>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-power-off"></i> Déconnexion</a>
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

        <main class="py-4">
            @yield('content')
        </main>

        <footer>
            4sucres.org / Powered by sucresBB
        </footer>
    </div>
</body>
</html>
