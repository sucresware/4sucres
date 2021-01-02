<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="description" content="Et vous, combien de sucres vous prenez dans votre café ?">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Inter:200,400,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:200,400,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans:200,400,600" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ url('/favicon.png') }}">
    <link href="{{ mix('/css/next.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/next.js') }}" defer></script>

    @routes

    <script>
        let defaultTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'sucresware-dark' : 'sucresware-light';
        let theme = localStorage.theme || defaultTheme;

        document.querySelector('html').setAttribute('data-theme', theme)
    </script>
</head>

<body class="font-sans text-base antialiased font-normal leading-normal bg-background-default text-on-background-default">
    @inertia
</body>

</html>