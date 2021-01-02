<template>
  <form class="max-w-lg p-8 mx-auto bg-white rounded-lg shadow" @submit.prevent="submit">
    <h1 class="text-2xl font-bold">Create a New Account</h1>

    <h3 class="mb-6 text-sm text-gray-600">
      Already have an account?
      <inertia-link :href="$route('login')" class="text-sm font-semibold text-gray-700">Sign In</inertia-link>
    </h3>

    <form-input
      class="mb-6"
      label="Name"
      placeholder="Your Name"
      v-model="form.name"
      :errors="$page.errors.name"
      autocomplete="name"
      required
      autofocus
    />

    <form-input
      class="mb-6"
      label="Email"
      placeholder="Your Email Address"
      v-model="form.email"
      :errors="$page.errors.email"
      autocomplete="email"
      required
    />

    <form-input
      class="mb-6"
      label="Password"
      placeholder="Your Password"
      type="password"
      v-model="form.password"
      :errors="$page.errors.password"
      autocomplete="new-password"
      required
    />

    <form-input
      class="mb-8"
      label="Confirm Password"
      placeholder="Confirm Your Password"
      type="password"
      v-model="form.password_confirmation"
      :errors="$page.errors.password_confirmation"
      autocomplete="new-password"
      required
    />

    <button
      class="w-full py-3 text-sm font-semibold text-white bg-gray-800 rounded-md hover:bg-gray-900 focus:outline-none focus:shadow-outline"
    >
      Sign Up
    </button>
  </form>
</template>

<script>
export default {
  /**
   * Layout of the page.
   *
   * @type {Object}
   */
  layout: require('../../layouts/app').default,

  /**
   * Component reactive data.
   *
   * @return {Object}
   */
  data() {
    return {
      form: {
        email: '',
        password: '',
        remember: false,
      },
    };
  },

  /**
   * Component methods.
   *
   * @type {Object}
   */
  methods: {
    /**
     * Submit the form.
     *
     * @return {void}
     */
    submit() {
      this.$page.errors = {};

      this.$inertia.post(this.$route('register'), { ...this.form });

      this.form.password = '';
      this.form.password_confirmation = '';
    },
  },
};
</script>
