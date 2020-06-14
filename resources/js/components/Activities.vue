<template>
  <div class>
    <div class="mb-3">
      <a href="#" class="btn btn-sm btn-primary" v-on:click="fullScreen()">
        <i class="fas fa-expand"></i> Élargir
      </a>
      <div v-if="page == 1" class="float-right">
        <span class="btn btn-primary btn-sm">
          <template v-if="pending"><i class="fas fa-sync fa-spin"></i> Fetching</template>
          <template v-else><i class="fas fa-sync"></i> Synced</template>
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
import AuthedAxios from "../scripts/axios";

var $ = require("jquery");

export default {
  props: ["initialPaginator"],
  data() {
    return {
      page: undefined,
      activities: [],
      pending: false,
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
    AuthedAxios.defaults.baseURL = "/admin/";

    let vm = this;

    if (this.initialPaginator) {
      this.activities = this.initialPaginator.data;
      this.page = this.initialPaginator.current_page;
    }

    if (this.page == 1) {
      Echo.echo.private(`Activities`).listen("ActivityLogged", e => {
        vm.pending = true;
        AuthedAxios.get('activity/' + e.activity_id)
          .then(resp => {
            vm.activities.unshift(resp.data.activity);
          })
          .finally(() => {
            vm.pending = false;
          });
      });
    }
  }
};
</script>