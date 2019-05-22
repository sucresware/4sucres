<!--
    Toi qui voit ce message, félicitation pour ton Ctrl+U.

    Poste le message suivant sur le Discord de 4sucres (https://discord.me/4sucres):
    C'était vraiment la meilleure farce du monde ! J'ai beaucoup ri ! Merci @MGK !
-->

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
    <meta name="description" content="Et vous, combien de sucres vous prenez dans votre café ?">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{ mix('css/4sucres.css') }}" rel="stylesheet">

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

    <style>
        html {
            height: 100%;
        }
    </style>
</head>
<body class="app-down">
    <div id="app" class="h-100">
        <div class="row no-gutters align-items-center justify-content-center h-100">
            <div class="col-10 col-md-6 col-lg-3">
                <div class="text-center mb-5">
                    <div class="spoiler">\o/</div><br>
                    <div class="spoiler">si tu lis ça t'es pd</div><br>
                    <div class="spoiler">mdrr, le site revient dans 5 minutes, juste le temps de la blague</div>
                </div>
                <div class="">
                    {!! File::get(base_path('/resources/svg/4sucres_alt.svg')) !!}
                </div>
                <div class="post mt-5 p-3 row no-gutters shadow ">
                    <div class="col-auto mr-3">
                        <img src="https://4sucres.org/storage/avatars/84_avatar1558102073.png" class="post-image rounded">
                    </div>
                    <div class="col">
                        <strong>PipBoy</strong>
                        <small>@PipBoy</small><br>
                        <small id="date">aujourd'hui à 16:09:57</small>
                        <hr>

                        <div class="post-content">
                            <p class="">je l'avais dit <img class="sticker-inline tooltip-inverse" src="https://image.noelshack.com/fichiers/2018/26/7/1530476579-reupjesus.png" data-toggle="tooltip" data-placement="top" data-html="true" title="" data-original-title="<img class=&quot;sticker&quot; src=&quot;https://image.noelshack.com/fichiers/2018/26/7/1530476579-reupjesus.png&quot;>"></p>

                            <p class="mb-0 baffle"><strong>Hacked By PipBoy</strong></p>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <div class="spoiler">mdrr, le site revient dans 5 minutes, juste le temps de la blague</div><br>
                    <div class="spoiler">si tu lis ça t'es pd</div><br>
                    <div class="spoiler">\o/</div>
                </div>
            </div>
        </div>

        {{--  <footer>
            &copy; 2019<br>
            <br>
            <strong>4sucres.org</strong>, parce qu'à 2 on était pas assez.<br>
            <a href="https://github.com/4sucres/board" target="_blank">GitHub</a>
        </footer>  --}}
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

    <script  src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</body>
</html>
