<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        4SUCRES.ORG
    </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        html, body, h-100 {
            height: 100%;
        }
    </style>
</head>
<body class="bg-primary">
    <div class="h-100 container">
        <div class="row h-100 align-items-center">
            <div class="col">
                <div class="row justify-content-center text-white">
                    <div class="col-12 col-md-6 col-lg-4 rounded">
                        <div class="bg-darker p-3 mb-3">
                            <img src="{{ url('/img/4sucres_alt_glitched.png') }}" class="img-fluid mb-3" style="width: 600px;">
                            <h5 class="mb-1">Salut le sucre !</h5>
                            <p class="text-justify">
                                Si t'es arrivé ici, c'est parce que t'en a plein le cul de la fermeture de <a href="https://2sucres.org" style="color: #ccc;">2sucres</a>, de la communauté toxique du <a href="https://lebunker.net" style="color: #ccc;">Bunker</a>, ou de l'absence complète de celle d'<a href="https://onche.party" style="color: #ccc;">Onche</a>. Soit pas con, et lâche ton email pour être tenu au courant de l'ouverture.<br>
                            </p>
                            @if (session()->has('success'))
                                <div class="alert alert-success mb-3">
                                    {{ session()->get('success') }}
                                </div>
                            @else
                                <form action="/optin" method="post">
                                    @csrf
                                    <input type="email" name="email" class="form-control mb-2" placeholder="chancla@gmail.com">
                                    <button type="submit" class="btn btn-success btn-block">Valider</button>
                                </form>
                            @endif
                        </div>
                        <div class="text-center">
                            <strong>4sucres.org</strong> - Parce que 2 c'était pas assez.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
