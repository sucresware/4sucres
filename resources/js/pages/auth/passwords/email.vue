<template>
  <form class="max-w-lg p-8 mx-auto overflow-hidden bg-white rounded-lg shadow" @submit.prevent="submit">
    <h3 v-if="success" class="px-4 py-3 mb-6 text-sm text-green-800 bg-green-100 rounded">
      We have e-mailed your password reset link!
    </h3>

    <h1 class="text-2xl font-bold">Reset Password</h1>

    <h3 class="mb-6 text-sm text-gray-600">
      Remembered Your Password?
      <inertia-link :href="$route('login')" class="text-sm font-semibold text-gray-700">Sign In</inertia-link>
    </h3>

    <form-input
      class="mb-8"
      label="Email"
      placeholder="Your Email Address"
      v-model="form.email"
      :errors="$page.errors.email"
      required
      autofocus
      autocomplete="email"
    />

    <button
      class="w-full py-3 text-sm font-semibold text-white bg-gray-800 rounded-md hover:bg-gray-900 focus:outline-none focus:shadow-outline"
    >
      Send Password Reset Link
    </button>
  </form>
</template>

<script>
import axios from 'axios';

export default {
  /**
   * Layout of the page.
   *
   * @type {Object}
   */
  layout: require('../../../layouts/app').default,

  /**
   * Component reactive data.
   *
   * @return {Object}
   */
  data() {
    return {
      form: {
        email: '',
      },
      success: false,
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
    async submit() {
      this.success = false;
      this.$page.errors = {};

      await this.$inertia.post(this.$route('password.email'), { ...this.form });

      if (!this.$page.errors.email) {
        this.form = {};
        this.success = true;
      }
    },
  },
};
</script>
