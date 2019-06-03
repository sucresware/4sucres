<template>
  <div class="discussion card mb-3">
    <template v-if="defaultPage > 1">
      <infinite-loading @infinite="infiniteHandlerTop" spinner="waveDots" direction="top">
        <div slot="no-more"></div>
        <div slot="no-results"></div>
      </infinite-loading>
    </template>

    <div
      v-for="(post, $index) in posts"
      :key="$index"
      :class="{'white': $index % 2 === 0, 'blue': $index % 2 !== 0 }"
    >
      <post :post="post"></post>
    </div>

    <infinite-loading @infinite="infiniteHandler" spinner="waveDots">
      <div slot="no-more"></div>
      <div slot="no-results"></div>
    </infinite-loading>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: ["discussionId", "defaultPosts", "defaultPage"],
  data() {
    return {
      page: undefined,
      pageTop: undefined,
      posts: []
    };
  },
  methods: {
    infiniteHandler($state) {
      axios
        .get("/api/v0/discussions/" + this.discussionId, {
          params: { page: this.page }
        })
        .then(({ data }) => {
          if (data.data.length) {
            this.page += 1;
            this.posts.push(...data.data);
            $state.loaded();
          } else {
            $state.complete();
          }
        });
    },
    infiniteHandlerTop($state) {
      if (this.pageTop <= 0) return $state.complete();

      axios
        .get("/api/v0/discussions/" + this.discussionId, {
          params: { page: this.pageTop }
        })
        .then(({ data }) => {
          if (data.data.length) {
            this.pageTop -= 1;
            this.posts = data.data.concat(this.posts);
            $state.loaded();
          } else {
            $state.complete();
          }
        });
    }
  },
  mounted: function() {
    if (this.defaultPage) {
      this.page = this.defaultPage;
      this.pageTop = this.defaultPage;
    } else {
      this.page = 1;
      this.pageTop = 1;
    }
  }
};
</script>