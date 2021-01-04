<template>
  <div
    class="w-full h-full p-4 overflow-y-auto scrollbar-thin bg-toolbar-default text-on-toolbar-default scrollbar-track-toolbar-default scrollbar-thumb-on-toolbar-border hover:scrollbar-thumb-on-toolbar-border"
    scroll-region
  >
    <div class="container">
      <subnav-settings class="mb-8" />
      <alerts class="mb-8" />

      <h1 class="mb-4 text-lg font-semibold">Profil</h1>

      <form class="w-full" @submit.prevent="submit">
        <div class="flex flex-row items-center mb-4">
          <div class="flex-none mr-4 w-avatar-xl">
            <img :src="user.avatar_link" class="rounded-avatar" />
          </div>

          <form-file-input
            type="file"
            class="flex-auto"
            label="Photo de profil"
            accept="image/*"
            ref="image"
            v-model="form.avatar"
            :errors="$page.props.errors.avatar"
            :disabled="loading"
          />
        </div>

        <form-input
          class="mb-4"
          label="Nom d'affichage"
          v-model="form.display_name"
          :errors="errors.display_name"
          :disabled="loading"
        />

        <form-textarea
          class="mb-4"
          rows="10"
          label="À propos"
          v-model="form.bio"
          :errors="errors.bio"
          :disabled="loading"
        />

        <div class="flex justify-end">
          <t-button @click="submit"> <i class="mr-2 opacity-50 fas fa-check"></i> Enregistrer </t-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  layout: require('../../layouts/app').default,

  props: {
    user: Object,
  },

  data() {
    return {
      errors: {},
      loading: false,
      form: {
        avatar: undefined,
        display_name: '',
        bio: '',
      },
    };
  },

  mounted() {
    this.form.display_name = this.user.display_name;
    this.form.bio = this.user.bio;
  },

  methods: {
    submit() {
      this.$page.props.errors = {};

      var data = new FormData();
      data.append('display_name', this.form.display_name || '');
      data.append('bio', this.form.bio || '');
      data.append('avatar', this.form.avatar || '');

      this.$inertia.post(route('next.settings.profile'), data);
    },
  },
};
</script>
