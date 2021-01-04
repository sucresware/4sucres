<template>
  <div
    class="w-full h-full p-4 overflow-y-auto scrollbar-thin bg-toolbar-default text-on-toolbar-default scrollbar-track-toolbar-default scrollbar-thumb-on-toolbar-border hover:scrollbar-thumb-on-toolbar-border"
    scroll-region
  >
    <t-card class="mb-4">
      <div class="flex flex-row">
        <div class="flex-none mr-4 w-avatar-xl">
          <img :src="user.avatar_link" :alt="user.name" class="rounded-avatar" />
        </div>
        <div class="flex-auto overflow-auto">
          <inertia-link @click.stop="" :href="$route('next.users.show', user.name)">
            <span class="text-muted">/u/{{ user.name }}</span>
            <h1 class="text-lg">
              {{ user.display_name }}
            </h1>
          </inertia-link>
          <div>{{ user.shown_role }}</div>

          <div>
            <strong class="text-lg">{{ user.threads_count }}</strong> threads
            <strong class="text-lg">{{ user.replies_count }}</strong> réponses
          </div>

          <div>
            <strong>Membre depuis :</strong>
          </div>

          <div>
            <strong>Dernière activité :</strong>
          </div>

          <strong>Description :</strong>
          <div>{{ user.bio }}</div>
        </div>
      </div>
    </t-card>

    <template v-if="user.bans.length">
      <h2 class="mb-4 text-lg font-semibold">Sanctions ({{ user.bans.length }})</h2>

      <t-card v-for="ban in user.bans" v-bind:key="ban.id" class="mb-4">
        <div>
          <strong v-if="ban.created_at == ban.expired_at" class="text-yellow-default">Avertissement</strong>
          <strong v-else class="text-red-default">
            Banissement
            <span v-if="!ban.expired_at">définitif</span>
            <span v-else>temporaire</span>
          </strong>
        </div>
        <div>{{ ban.comment }}</div>

        <div>
          le {{ moment(ban.created_at).format('L') }}
          <span v-if="ban.created_at != ban.expired_at && ban.expired_at">
            <span class="text-on-background-muted">&bullet;</span>
            {{ moment(ban.expired_at).diff(moment(ban.created_at), 'days') }} jour(s)
          </span>
        </div>
      </t-card>
    </template>

    <h2 class="mb-4 text-lg font-semibold">Succès</h2>

    <t-card v-for="achievement in user.achievements" v-bind:key="achievement.id" class="mb-4">
      <div class="flex flex-row items-center">
        <img :src="'/img/achievements/' + achievement.image" class="w-12 mr-4" />
        <div>
          <strong>
            <span v-if="achievement.rare" class="text-orange-default"><i class="fas fa-star"></i></span>
            {{ achievement.name }} </strong
          ><br />
          {{ achievement.description }}<br />
          <span class="text-sm">Obtenu le {{ moment(achievement.pivot.unlocked_at).format('L') }}</span>
        </div>
      </div>
    </t-card>
  </div>
</template>

<script>
export default {
  layout: require('../../layouts/app').default,

  props: {
    user: Object,
  },

  data() {
    return {};
  },

  mounted() {},

  methods: {},
};
</script>
