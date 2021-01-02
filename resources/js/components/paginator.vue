<template>
  <div class="flex flex-row items-center justify-between">
    <t-button
      :disabled="paginator.current_page <= 1"
      @click="visit(paginator.prev_page_url)"
      variant="secondary"
      class="mr-1"
      ><i class="fas fa-fw fa-angle-left"></i
    ></t-button>
    <div class="hidden mx-1 text-sm sm:block">
      {{ paginator.current_page }} <span class="text-on-background-muted">/</span> {{ paginator.last_page }}
    </div>
    <t-button
      :disabled="paginator.current_page == paginator.last_page"
      @click="visit(paginator.next_page_url)"
      variant="secondary"
      class="ml-1"
      ><i class="fas fa-fw fa-angle-right"></i
    ></t-button>
  </div>
</template>

<script>
export default {
  props: ['paginator', 'only'],

  methods: {
    visit(url) {
      if (this.only) {
        let queryString = url.replace(this.paginator.path, '');
        let currentUrl = window.location.href.split('?')[0];
        return this.$inertia.visit(currentUrl + queryString, { only: this.only });
      }

      return this.$inertia.visit(url);
    },
  },
};
</script>
