<template>
  <div
    class="w-full h-full p-4 overflow-y-auto scrollbar-thin bg-toolbar-default text-on-toolbar-default scrollbar-track-toolbar-default scrollbar-thumb-on-toolbar-border hover:scrollbar-thumb-on-toolbar-border"
    scroll-region
  >
    <div class="container">
      <subnav-settings class="mb-8" />
      <alerts class="mb-8" />

      <h1 class="mb-4 text-lg font-semibold">Mot de passe</h1>

      <form class="w-full" @submit.prevent="submit">
        <form-input
          class="mb-4"
          label="Mot de passe actuel"
          v-model="form.current_password"
          :errors="$page.props.errors.current_password"
          :disabled="loading"
          type="password"
          autocomplete="current-password"
        />

        <form-input
          class="mb-4"
          label="Nouveau mot de passe"
          v-model="form.password"
          :errors="$page.props.errors.password"
          :disabled="loading"
          type="password"
          autocomplete="new-password"
        />

        <form-input
          class="mb-4"
          label="Nouveau mot de passe (confirmation)"
          v-model="form.password_confirmation"
          :errors="$page.props.errors.password_confirmation"
          :disabled="loading"
          type="password"
          autocomplete="new-password"
        />

        <div class="flex justify-end">
          <t-button @click="submit"> <i class="mr-2 opacity-50 fas fa-check"></i> Enregistrer </t-button>
        </div>
      </form>

      <h1 class="mb-4 text-lg font-semibold">Authentification à deux facteurs (TOTP)</h1>

      <t-card>
        <div class="prose max-w-none">
          <p>
            <strong>Protège ton compte avec le 2FA !</strong><br />
            L’authentification à deux facteurs (2FA) est une fonction de sécurité qui aide à protéger ton compte 4sucres
            en plus de ton mot de passe. Un second mot de passe temporaire et unique (TOTP) te sera demandé à chaque
            connexion.<br />
            Pour utiliser le 2FA, tu dois installer une application compatible Google Autenticator. Par exemple :
          </p>
          <ul>
            <li>
              Google Authenticator (<a
                href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=fr"
                target="_blank"
                >Android</a
              >, <a href="https://apps.apple.com/fr/app/google-authenticator/id388497605" target="_blank">iOS</a>)
            </li>
            <li>
              <a href="https://1password.com/" target="_blank">1Password (Android, iOS, Chrome, Windows, macOS)</a>
            </li>
            <li>
              <a href="https://www.authy.com/" target="_blank">Authy (Android, iOS, Chrome, macOS)</a>
            </li>
            <li>
              <a href="https://lastpass.com/auth/" target="_blank"
                >LastPass Authenticator (Android, iOS, Windows, macOS)</a
              >
            </li>
          </ul>
        </div>

        <div class="alert" v-if="google_2fa.enabled">
          <div v-html="google_2fa.qr_image"></div>
          <p>
            Configure le 2FA en scannant le code ci-dessus.<br />
            Tu peux aussi directement utiliser le code : <strong>{{ google_2fa.secret }}</strong
            ><br />
            <br />
            <strong class="text-danger"
              >Tu dois configurer ton application Google Authenticator maintenant avant de continuer,
              <span class="spoiler">sinon tu ne pourras plus te connecter <span class="spoiler">gros singe</span></span
              >.</strong
            ><br />
          </p>
        </div>

        <div class="flex justify-end">
          <t-button @click="$inertia.post($route('next.settings.security.2fa.enable'))" v-if="!google_2fa.enabled">
            <i class="mr-2 opacity-50 fas fa-key"></i> Activer le 2FA
          </t-button>
          <t-button @click="$inertia.post($route('next.settings.security.2fa.disable'))" v-if="google_2fa.enabled">
            <i class="mr-2 opacity-50 fas fa-times"></i> Désactiver le 2FA
          </t-button>
        </div>
      </t-card>
    </div>
  </div>
</template>

<script>
export default {
  layout: require('../../layouts/app').default,

  props: {
    google_2fa: Object,
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
