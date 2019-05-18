<div class="nav flex-column nav-pills">
    <a href="{{ route('user.settings.profile', $user->name) }}" class="nav-link {{ active([route('user.settings.profile')]) }} {{ active([route('user.settings.profile', $user->name)]) }}"><i class="fas fa-fw fa-user"></i> Profil</a>
    @if ($user->id == user()->id)
        <a href="{{ route('user.settings.account.email') }}" class="nav-link {{ active([route('user.settings.account.email')]) }}"><i class="fas fa-fw fa-at"></i> Adresse e-mail</a>
        <a href="{{ route('user.settings.account.password') }}" class="nav-link {{ active([route('user.settings.account.password')]) }}"><i class="fas fa-fw fa-key"></i> Mot de passe</a>
        <a href="{{ route('user.settings.layout') }}" class="nav-link {{ active([route('user.settings.layout')]) }}"><i class="fas fa-fw fa-paint-brush"></i> Affichage</a>
        <a href="{{ route('user.settings.notifications') }}" class="nav-link {{ active([route('user.settings.notifications')]) }}"><i class="fas fa-fw fa-star-of-life"></i> Notifications</a>
    @endif
</div>