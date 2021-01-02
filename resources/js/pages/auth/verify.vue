<template>
  <form class="max-w-lg p-8 mx-auto bg-white rounded-lg shadow" @submit.prevent="submit">
    <h1 class="mb-6 text-2xl font-bold">Verify Your Email Address</h1>

    <h3 class="mb-10 text-sm text-gray-600">
      Before proceeding, please check your email for a verification link. If you did not receive the email click the
      button below to request another.
    </h3>

    <button
      class="w-full py-3 text-sm font-semibold text-white bg-gray-800 rounded-md hover:bg-gray-900 focus:outline-none focus:shadow-outline"
    >
      Resend Verification Email
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

      this.$inertia.post(this.$route('verification.resend'), { ...this.form });

      this.form.password = '';
    },
  },
};
</script>
