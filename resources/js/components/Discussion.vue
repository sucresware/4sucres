<template>
  <section class="mb-3 discussion card">
    <div v-for="(post, $index) in posts" class="post-container" :key="$index">
      <post :post="post"></post>
    </div>
  </section>
</template>

<script>
import axios from 'axios';

export default {
  props: ['discussionId', 'initialPaginator'],
  data() {
    return {
      page: undefined,
      posts: [],
    };
  },
  methods: {},
  mounted: function() {
    if (this.initialPaginator) {
      this.posts = this.initialPaginator.data;
      this.page = this.initialPaginator.currentPage;
    }
  },
};
</script>
