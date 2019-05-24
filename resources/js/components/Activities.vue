<template>
  <div class>
    <div v-if="page == 1" class="text-right mb-3">
      <span class="badge badge-success text-white">
        <i class="fas fa-sync fa-spin"></i> Sync
      </span>
    </div>
    <div class="card shadow-sm">
      <div v-for="(activity, $index) in activities" :key="$index">
        <activity :activity="activity"></activity>
      </div>
    </div>
  </div>
</template>

<script>
import Echo from "../scripts/echo";

export default {
  props: ["initialPaginator"],
  data() {
    return {
      page: undefined,
      activities: []
    };
  },
  methods: {},
  mounted: function() {
    if (this.initialPaginator) {
      this.activities = this.initialPaginator.data;
      this.page = this.initialPaginator.current_page;
    }

    if (this.page == 1) {
      Echo.echo.private(`Activities`).listen("ActivityLogged", e => {
        this.activities.unshift(e.activity);
      });
    }
  }
};
</script>