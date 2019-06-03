<template>
  <div class>
    <div class="mb-3">
      <a href="#" class="btn btn-sm btn-primary" v-on:click="fullScreen()">
        <i class="fas fa-expand"></i> Élargir
      </a>
      <div v-if="page == 1" class="float-right">
        <span class="btn btn-success btn-sm">
          <i class="fas fa-sync fa-spin"></i> Synced
        </span>
      </div>
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
var $ = require("jquery");

export default {
  props: ["initialPaginator"],
  data() {
    return {
      page: undefined,
      activities: []
    };
  },
  methods: {
    fullScreen() {
      $(".sticky-top").toggle();
      $(".col-lg-3.col-xl-2.mb-3").toggle();
      $("footer").toggle();
      // $("main").toggleClass("py-4");
    }
  },
  mounted: function() {
    if (this.initialPaginator) {
      this.activities = this.initialPaginator.data;
      this.page = this.initialPaginator.current_page;
    }

    if (this.page == 1) {
      Echo.echo.private(`Activities`).listen("ActivityLogged", e => {
        this.activities.unshift(e.activity);
        // this.activities.push(e.activity);
        // vm.$forceUpdate();
      });
    }
  }
};
</script>