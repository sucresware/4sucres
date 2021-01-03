<template>
  <div
    class="w-full h-full p-4 overflow-y-auto scrollbar-thin scrollbar-track-toolbar-default scrollbar-thumb-on-toolbar-border hover:scrollbar-thumb-on-toolbar-border"
    scroll-region
  >
    <div class="container">
      <subnav-settings />

      <h1 class="mb-4 text-lg font-semibold">Modification du mot de passe</h1>

      <form class="w-full" @submit.prevent="submit">
        <form-input
          class="mb-4"
          label="Mot de passe actuel"
          v-model="form.current_password"
          :errors="errors.current_password"
          :disabled="loading"
          required
        />

        <form-input
          class="mb-4"
          label="Nouveau mot de passe"
          v-model="form.password"
          :errors="errors.password"
          :disabled="loading"
          required
        />

        <form-input
          class="mb-4"
          label="Nouveau mot de passe (confirmation)"
          v-model="form.password_confirmation"
          :errors="errors.password_confirmation"
          :disabled="loading"
          required
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
        current_password: '',
        password: '',
        password_confirmation: '',
      },
    };
  },

  methods: {
    submit() {
      this.$page.props.errors = {};

      this.$inertia.post(route('next.settings.security'), this.form);
    },
  },
};
</script>
