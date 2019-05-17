<template>
  <div class="card mb-3">
    <div
      v-for="(post, $index) in posts"
      :key="$index"
      :class="{'white': $index % 2 === 0, 'blue': $index % 2 !== 0 }"
    >
      <post :post="post"></post>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: ["discussionId", "initialPaginator"],
  data() {
    return {
      page: undefined,
      posts: []
    };
  },
  methods: {},
  mounted: function() {
    console.log(this.initialPaginator);

    if (this.initialPaginator) {
      this.posts = this.initialPaginator.data;
      this.page = this.initialPaginator.currentPage;
    }
  }
};
</script>