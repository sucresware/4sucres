<template>
  <div
    class="flex flex-row flex-wrap items-start justify-start mb-4 font-semibold border-b border-on-background-border"
    scroll-region
  >
    <inertia-link
      :href="$route('next.settings.profile')"
      class="flex-none block px-3 py-2 border-b-4 hover:text-on-background-default"
      preserve-scroll
      :class="{
        'text-on-background-muted border-transparent': !$route().current('next.settings.profile'),
        'text-on-background-default border-accent-default': $route().current('next.settings.profile'),
      }"
    >
      <i class="mr-1 text-on-background-muted fas fa-fw fa-user"></i> Profil
    </inertia-link>
    <inertia-link
      :href="$route('next.settings.account')"
      class="flex-none block px-3 py-2 border-b-4 hover:text-on-background-default"
      preserve-scroll
      :class="{
        'text-on-background-muted border-transparent': !$route().current('next.settings.account'),
        'text-on-background-default border-accent-default': $route().current('next.settings.account'),
      }"
    >
      <i class="mr-1 text-on-background-muted fas fa-fw fa-at"></i> Compte
    </inertia-link>
    <inertia-link
      :href="$route('next.settings.security')"
      class="flex-none block px-3 py-2 border-b-4 hover:text-on-background-default"
      preserve-scroll
      :class="{
        'text-on-background-muted border-transparent': !$route().current('next.settings.security'),
        'text-on-background-default border-accent-default': $route().current('next.settings.security'),
      }"
    >
      <i class="mr-1 text-on-background-muted fas fa-fw fa-key"></i> Sécurité
    </inertia-link>
    <inertia-link
      :href="$route('next.settings.notifications')"
      class="flex-none block px-3 py-2 border-b-4 hover:text-on-background-default"
      preserve-scroll
      :class="{
        'text-on-background-muted border-transparent': !$route().current('next.settings.notifications'),
        'text-on-background-default border-accent-default': $route().current('next.settings.notifications'),
      }"
    >
      <i class="mr-1 text-on-background-muted fas fa-fw fa-star-of-life"></i> Notifications
    </inertia-link>
    <inertia-link
      :href="$route('next.settings.design')"
      class="flex-none block px-3 py-2 border-b-4 hover:text-on-background-default"
      preserve-scroll
      :class="{
        'text-on-background-muted border-transparent': !$route().current('next.settings.design'),
        'text-on-background-default border-accent-default': $route().current('next.settings.design'),
      }"
    >
      <i class="mr-1 text-on-background-muted fas fa-fw fa-paint-brush"></i> Design
    </inertia-link>
  </div>
</template>
