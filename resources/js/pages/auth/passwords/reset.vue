<template>
  <form
    class="max-w-lg p-8 mx-auto bg-white rounded-lg shadow"
    @submit.prevent="submit"
  >
    <h1 class="mb-6 text-2xl font-bold">Reset Password</h1>

    <form-input
      class="mb-6"
      label="Email"
      placeholder="Your Email Address"
      v-model="form.email"
      :errors="$page.errors.email"
      required
      autocomplete="email"
    />

    <form-input
      class="mb-6"
      label="Password"
      placeholder="Your Password"
      type="password"
      v-model="form.password"
      :errors="$page.errors.password"
      autocomplete="new-password"
      autofocus
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
      Reset Password
    </button>
  </form>
</template>

<script>
import axios from "axios";

export default {
  /**
   * Layout of the page.
   *
   * @type {Object}
   */
  layout: require("../../../layouts/app").default,

  /**
   * Component properties.
   *
   * @type {Object}
   */
  props: {
    email: String,
    token: String,
  },

  /**
   * Component reactive data.
   *
   * @return {Object}
   */
  data() {
    return {
      form: {
        token: this.token,
        email: this.email,
        password: "",
        password_confirmation: "",
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

      this.$inertia.post(this.$route("password.update"), { ...this.form });

      this.form.password = "";
      this.form.password_confirmation = "";
    },
  },
};
</script>