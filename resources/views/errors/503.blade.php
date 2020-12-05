<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        4sucres.org
    </title>

    <meta name="description" content="Et vous, combien de sucres vous prenez dans votre café ?">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{ mix('css/theme-dark.css') }}" rel="stylesheet">

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
                <div class="mx-auto animated fadeIn" style="width: 250px">
                    {!! File::get(base_path('/resources/svg/4sucres_alt.svg')) !!}
                </div>

                <video data-role="video" data-autoplay="true" loop="true" controls="true" class="mt-5 shadow img-fluid">
                    <source src="{{ url('/video/503.webm')}}" type="video/webm">
                </video>
            </div>
        </div>
    </div>

    @routes
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
