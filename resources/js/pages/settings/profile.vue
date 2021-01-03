<template>
  <div
    class="w-full h-full p-4 overflow-y-auto scrollbar-thin scrollbar-track-toolbar-default scrollbar-thumb-on-toolbar-border hover:scrollbar-thumb-on-toolbar-border"
    scroll-region
  >
    <div class="container">
      <subnav-settings />

      <h1 class="mb-4 text-lg font-semibold">Modification du profil</h1>

      <form class="w-full" @submit.prevent="submit">
        <div class="flex flex-row items-center mb-4">
          <div class="flex-none mr-4 w-avatar-xl">
            <img src="https://4sucres-next.localhost/img/pp/indep.png" alt="YvonEnbaver" class="rounded-avatar" />
          </div>

          <form-file-input
            type="file"
            class="flex-auto"
            label="Photo de profil"
            accept="image/*"
            ref="image"
            v-model="form.profile_picture"
            :errors="$page.props.errors.profile_picture"
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
        profile_picture: undefined,
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
      data.append('profile_picture', this.form.profile_picture || '');

      this.$inertia.post(route('next.settings.profile'), data);
    },
  },
};
</script>
