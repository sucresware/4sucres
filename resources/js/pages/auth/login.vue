<template>
  <form class="w-full max-w-sm" @submit.prevent="submit">
    <template v-if="!totp_required">
      <inertia-link :href="$route('next.home')">
        <img src="/img/4sucres_alt_glitched.png" alt="4sucres.org" class="h-16 mx-auto mb-8" />
      </inertia-link>

      <div class="mb-8 text-center">
        <h1 class="text-xl font-bold">Connexion à 4sucres.org</h1>
        <h3 class="text-sm">
          T'as pas de compte ?
          <inertia-link :href="$route('register')" class="text-sm font-semibold">
            Inscription
          </inertia-link>
        </h3>
      </div>

      <form-input
        class="mb-6"
        label="Adresse e-mail"
        v-model="form.email"
        :errors="errors.email"
        :disabled="loading"
        required
        autofocus
        autocomplete="email"
      />

      <form-input
        class="mb-2"
        label="Mot de passe"
        type="password"
        v-model="form.password"
        :errors="errors.password"
        :disabled="loading"
        required
        autocomplete="current-password"
      />

      <div class="mb-8 text-right">
        <inertia-link class="text-sm hover:" :href="$route('password.request')">Oublié ?</inertia-link>
      </div>
    </template>

    <template v-if="totp_required">
      <img class="w-64 mx-auto mb-8" src="/img/settings/google_2fa.png" />

      <div class="mb-8 text-center">
        <h1 class="text-xl font-bold">Connexion à 4sucres.org</h1>
        <h3 class="text-sm">Authentification à deux facteurs</h3>
      </div>

      <form-input
        class="mb-8"
        label="OTP"
        type="text"
        v-model="form.totp"
        :errors="errors.totp"
        :disabled="loading"
        required
      />
    </template>

    <t-button class="w-full" variant="large" type="submit" :disabled="loading">
      <span v-if="loading"><i class="fas fa-spinner fa-spin"></i></span>
      <span v-if="!loading">Valider</span>
    </t-button>
  </form>
</template>

<script>
export default {
  layout: require('../../layouts/gate').default,

  data() {
    return {
      errors: {},
      form: {
        email: '',
        password: '',
        remember: false,
        totp: '',
      },
      loading: false,
      totp_required: false,
    };
  },

  methods: {
    submit() {
      if (this.loading) return;

      this.loading = true;

      axios
        .post(route('next.login'), { ...this.form })
        .then((response) => {
          this.$inertia.visit(response.data.intended_url);
        })
        .catch((error) => {
          this.errors = error.response.data.errors;

          if (this.errors.totp) {
            if (!this.totp_required) {
              this.errors = {};
            }
            this.totp_required = true;
          } else {
            this.form.password = '';
          }
        })
        .finally((response) => {
          this.loading = false;
        });
    },
  },
};
</script>
