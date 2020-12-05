<template>
  <form class="w-full max-w-sm" @submit.prevent="submit">
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
      :errors="$page.props.errors.email"
      required
      autofocus
      autocomplete="email"
    />

    <form-input
      class="mb-2"
      label="Mot de passe"
      type="password"
      v-model="form.password"
      :errors="$page.props.errors.password"
      required
      autocomplete="current-password"
    />

    <div class="mb-8 text-right">
      <inertia-link class="text-sm hover:" :href="$route('password.request')"
        >Oublié ?</inertia-link
      >
    </div>

    <t-button class="w-full" variant="large" type="submit">Connexion</t-button>
  </form>
</template>

<script>
export default {
  layout: require("../../layouts/gate").default,

  data() {
    return {
      form: {
        email: "",
        password: "",
        remember: false,
      },
    };
  },

  methods: {
    submit() {
      this.$page.props.errors = {};

      this.$inertia.post(this.$route("next.login"), { ...this.form });

      this.form.password = "";
    },
  },
};
</script>