<template>
  <div
    class="w-full h-full p-4 overflow-y-auto scrollbar-thin bg-toolbar-default text-on-toolbar-default scrollbar-track-toolbar-default scrollbar-thumb-on-toolbar-border hover:scrollbar-thumb-on-toolbar-border"
    scroll-region
  >
    <div class="container">
      <subnav-settings class="mb-8" />
      <alerts class="mb-8" />

      <h1 class="mb-4 text-lg font-semibold">Préférences de notification</h1>
    </div>
  </div>
</template>

<script>
export default {
  layout: require('../../layouts/app').default,

  props: {
    // user: Object,
  },

  data() {
    return {};
  },

  mounted() {},

  methods: {},
};
</script>
