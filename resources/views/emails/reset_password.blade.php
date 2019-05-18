@component('mail::message')
# Alors comme ça on a perdu son mot de passe ?

Yo {{ $user->display_name }} !

Balance ton nouveau mot de passe ici :

@component('mail::button', ['url' => route('password.reset', $token))])
Changer mon mot de passe
@endcomponent

Merci,<br>
L'équipe 4sucres
@endcomponent