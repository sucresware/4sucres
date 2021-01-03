<template>
  <div
    class="w-full h-full p-4 overflow-y-auto scrollbar-thin scrollbar-track-toolbar-default scrollbar-thumb-on-toolbar-border hover:scrollbar-thumb-on-toolbar-border"
    scroll-region
  >
    <div class="container">
      <subnav-settings />

      <h1 class="mb-4 text-lg font-semibold">Modification de l'adresse e-mail</h1>

      <form class="w-full" @submit.prevent="submit">
        <form-input
          class="mb-4"
          label="Adresse e-mail"
          v-model="form.email"
          :errors="errors.email"
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
        email: '',
      },
    };
  },

  mounted() {
    this.form.email = this.user.email;
  },

  methods: {
    submit() {
      this.$page.props.errors = {};

      this.$inertia.post(route('next.settings.account'), this.form);
    },
  },
};
</script>
