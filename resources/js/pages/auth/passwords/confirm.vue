<template>
  <form
    class="max-w-lg p-8 mx-auto bg-white rounded-lg shadow"
    @submit.prevent="submit"
  >
    <h1 class="text-2xl font-bold">Confirm Password</h1>

    <h3 class="mb-6 text-sm text-gray-600">
      Please confirm your password before continuing.
    </h3>

    <form-input
      class="mb-2"
      label="Password"
      placeholder="Your Password"
      type="password"
      v-model="form.password"
      :errors="$page.errors.password"
      required
      autocomplete="current-password"
    />

    <div class="mb-8 text-right">
      <inertia-link
        class="text-sm text-gray-600 hover:text-gray-800"
        :href="$route('password.request')"
        >Forgot Password?</inertia-link
      >
    </div>

    <button
      class="w-full py-3 text-sm font-semibold text-white bg-gray-800 rounded hover:bg-gray-900 focus:outline-none focus:shadow-outline"
    >
      Confirm Password
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
        password: "",
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

      this.$inertia.post(this.$route("password.confirm"), { ...this.form });

      this.form.password = "";
    },
  },
};
</script>