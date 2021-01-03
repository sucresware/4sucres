<template>
  <div
    class="w-full h-full p-4 overflow-y-auto scrollbar-thin scrollbar-track-toolbar-default scrollbar-thumb-on-toolbar-border hover:scrollbar-thumb-on-toolbar-border"
    scroll-region
  >
    <div class="container">
      <subnav-settings />
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
