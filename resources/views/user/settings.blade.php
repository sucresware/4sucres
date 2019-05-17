@extends('layouts.app')

@section('title')
    Paramètres
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="{{ route('user.settings', []) }}" enctype='multipart/form-data' id="settings">
                @method('put')
                @csrf

                <div class="card mb-3">
                    <div class="card-header">
                        Paramètres d'affichage
                    </div>
                    <div class="card-body dimmed-border-bottom">
                        <div class="form-group px-4">
                            <div class="row justify-content-center mb-2">
                                <label for="sidebar" class="form-label font-weight-bold text-uppercase">Position de la barre latérale</label>
                            </div>
                            <div class="row">
                                <div class="custom-control custom-radio flex-center col mb-3 mb-md-0">
                                    <input name="sidebar" id="sidebar_left" type="radio" value="left" {{ old('sidebar', $user->getSetting('layout.sidebar', 'left')) == "left" ? 'checked' : '' }} class="custom-control-input">
                                    <label for="sidebar_left" class="custom-control-label"><img src="{{ url('/img/settings/layout.sidebar.left.png') }}" class="img-fluid rounded" style="width: 300px"></label>
                                </div>
                                <div class="custom-control custom-radio flex-center col pr-0">
                                    <input name="sidebar" id="sidebar_right" type="radio" value="right" {{ old('sidebar', $user->getSetting('layout.sidebar', 'left')) == "right" ? 'checked' : '' }} class="custom-control-input">
                                    <label for="sidebar_right" class="custom-control-label"><img src="{{ url('/img/settings/layout.sidebar.right.png') }}" class="img-fluid rounded" style="width: 300px"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group px-4">
                            <div class="row justify-content-center mb-2">
                                <label for="stickers" class="form-label font-weight-bold text-uppercase">Adaptation de la taille des stickers Risibank</label>
                            </div>
                            <div class="row">
                                <div class="custom-control custom-radio flex-center col mb-3 mb-md-0">
                                    <input name="stickers" id="default" type="radio" value="default" {{ old('stickers', $user->getSetting('layout.stickers', 'default')) == "default" ? 'checked' : '' }} class="custom-control-input">
                                    <label for="default" class="custom-control-label"><img src="{{ url('/img/settings/layout.stickers.default.png') }}" class="img-fluid rounded" style="width: 300px"></label>
                                    <small id="stickers_help" class="form-text text-muted mt-2">
                                        Cette disposition permet d'afficher les stickers agrandis par défaut.
                                    </small>
                                </div>
                                <div class="custom-control custom-radio flex-center col pr-0">
                                    <input name="stickers" id="stickers_inline" type="radio" value="inline" {{ old('stickers', $user->getSetting('layout.stickers', 'default')) == "inline" ? 'checked' : '' }} class="custom-control-input">
                                    <label for="stickers_inline" class="custom-control-label"><img src="{{ url('/img/settings/layout.stickers.inline.png') }}" class="img-fluid rounded" style="width: 300px"></label>
                                    <small id="stickers_inline_help" class="form-text text-muted mt-2">
                                        Cette disposition permet d'agrandir la taille des stickers au survol de la souris.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        Gestion des notifications
                    </div>
                    <div class="card-body">
                        {{--  <div class="row">
                            <div class="col-md-3">Je souhaite être notifié..</div>
                            <div class="col-md-9">
                                <div class="form-group mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="webpush" {{ old('webpush') ? 'checked' : '' }} >
                                        <label class="custom-control-label" for="webpush">
                                            De toutes les nouvelles discussions
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="webpush" {{ old('webpush') ? 'checked' : '' }} >
                                        <label class="custom-control-label" for="webpush">
                                            Quand je reçois un message privé
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="webpush" {{ old('webpush') ? 'checked' : '' }} >
                                        <label class="custom-control-label" for="webpush">
                                            Quand je suis cité/mentionné
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>  --}}
                        <div class="form-group">
                            <div class="alert alert-primary">
                                <div class="row align-items-center">
                                    <div class="col col-md-8">
                                        <p>
                                            Le WebPush c'est génial, so STARTUP NATION !<br>
                                            Ça permet de reçevoir une notification sur ton téléphone (ou PC) sans même que ton navigateur soit ouvert. Un peu comme un app, mais avec 3 lettres en moins.<br>
                                        </p>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="optin_webpush" name="optin_webpush" {{ old('optin_webpush', $user->getSetting('webpush.enabled', 0)) ? 'checked' : '' }} value="1">
                                            <label class="custom-control-label" for="optin_webpush">
                                                Activer les notifications WebPush (expérimental)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-none d-md-flex col-md-4 pr-1">
                                        <a href='{{ url('/img/settings/notifications.webpush.gif') }}' data-toggle='fancybox' data-type='image'>
                                            <img src="{{ url('/img/settings/notifications.webpush.gif') }}" class="img-fluid rounded">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="webpush_settings" style="display: none;">
                            <div class="alert border">
                                <p>
                                    Tu dois autoriser <strong>chaque appareil</strong> sur lequel tu veux recevoir des notifications WebPush :<br>
                                    <small>Si y'a rien quand t'appuie sur "Autoriser cet appareil", y'a un souci.</small>
                                </p>

                                <a href="javascript:void(0)" class="btn btn-primary mb-1" id="enable-webpush" onclick="enableNotifications()">Autoriser cet appareil</a>
                                {{--  <a href="javascript:void(0)" class="btn btn-danger mb-1" id="disable-webpush">Révoquer cet appareil</a>  --}}
                                {{--  <a href="javascript:void(0)" class="btn btn-danger mb-1" id="">Révoquer tous les appareils</a>  --}}
                                <a href="javascript:void(0)" class="btn btn-secondary mb-1" id="test-notification" style="display: none;" onclick="testNotification()">Envoyer une notification de test</a>
                            </div>

                            {!! BootForm::select('idle_wait', 'Lorsque je ne suis pas actif&middot;ve sur 4sucres, envoyer les notifications WebPush :', [
                                0 => 'immédiatement',
                                1 => 'après 1 minute d\'inactivité',
                                2 => 'après 2 minutes d\'inactivité',
                                5 => 'après 5 minutes d\'inactivité',
                                10 => 'après 10 minutes d\'inactivité',
                                15 => 'après 15 minutes d\'inactivité',
                                20 => 'après 20 minutes d\'inactivité',
                                30 => 'après 30 minutes d\'inactivité',
                            ], old('idle_wait', $user->getSetting('webpush.idle_wait', 1)), [
                                'help_text' => 'FYI: Garder un onglet ouvert sur 4sucres.org est considéré comme une activité.'
                            ]) !!}
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Enregistrer les paramètres</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $('#settings').change(function(){
        refreshForm();
    });

    $(document).ready(function(){
        refreshForm();
    });

    function refreshForm(){
        if (!$('#optin_webpush').is(':checked')) {
            $("#webpush_settings").slideUp('fast')
        } else {
            registerServiceWorker()
            $("#webpush_settings").slideDown('fast')
        }
    }

    var _registration = null;

    function registerServiceWorker() {
        return navigator.serviceWorker.register('/js/service-worker.js')
            .then(function (registration) {
                console.log('Service worker successfully registered.');
                _registration = registration;
                registration.update()
                return registration;
            })
            .catch(function (err) {
                console.error('Unable to register service worker.', err);
            });
    }

    function askPermission() {
        return new Promise(function (resolve, reject) {
            const permissionResult = Notification.requestPermission(function (result) {
                resolve(result);
            });
            if (permissionResult) {
                permissionResult.then(resolve, reject);
            }
        })
        .then(function (permissionResult) {
            if (permissionResult !== 'granted') {
                throw new Error('We weren\'t granted permission.');
            } else {
                subscribeUserToPush();
            }
        });
    }

    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    function getSWRegistration() {
        var promise = new Promise(function (resolve, reject) {
            if (_registration != null) {
                resolve(_registration);
            } else {
                reject(Error("It broke"));
            }
        });
        return promise;
    }

    function subscribeUserToPush() {
        getSWRegistration()
            .then(function (registration) {
                console.log(registration);
                const subscribeOptions = {
                    userVisibleOnly: true,
                    applicationServerKey: urlBase64ToUint8Array(
                        "{{ env('VAPID_PUBLIC_KEY') }}"
                    )
                };
                return registration.pushManager.subscribe(subscribeOptions);
            })
            .then(function (pushSubscription) {
                console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
                sendSubscriptionToBackEnd(pushSubscription);
                return pushSubscription;
            });
    }

    function sendSubscriptionToBackEnd(subscription) {
        return fetch('/api/v0/webpush/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': @json(csrf_token())
                },
                body: JSON.stringify(subscription)
            })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Bad status code from server.');
                }
                $("#enable-webpush").hide();
                $("#test-notification").show();
                return response.json();
            })
            .then(function (responseData) {
                if (!(responseData && responseData.success)) {
                    throw new Error('Bad response from server.');
                }
            });
    }

    function enableNotifications() {
        askPermission();
    }

    function testNotification(){
        _registration.showNotification('J\'suis allé à ma voiture j\'men vais !', {
            body: 'Et puis quand j\'arrive sur le truc pour rentrer sur Colmar..',
            icon: @json(url('/img/webpush/icon.png')),
            badge: @json(url('/img/webpush/badge.png')),
        });
    }
</script>
@endpush