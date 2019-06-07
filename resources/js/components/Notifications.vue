<template>
  <b-dropdown
    no-caret
    variant="link"
    id="notifications"
    class="ml-auto mr-1 text-center order-lg-7 notification-dropdown"
    right
  >
    <template slot="button-content">
      <span class="fa-stack notification" id="notifications_indicator">
        <i
          :class="{ 'fas fa-circle fa-stack-2x notification-background': true, 'text-primary': !hidden }"
        ></i>
        <i
          :class="{ 'fas fa-bell fa-stack-1x fa-sm notification-icon': true, 'text-white': !hidden }"
        ></i>
        <span class="badge badge-danger badge-pill notification-counter" v-if="count">{{ count }}</span>
      </span>
    </template>

    <div class="text-center text-muted py-5" v-if="loading">
      <i class="fas fa-sync fa-spin"></i>
    </div>

    <div v-else>
      <div class="text-center text-muted py-3" v-if="notifications.length == 0">
        <img src="https://4sucres.org/svg/sucre_sad.svg" width="50px" class="img-fluid">
        <br>
        <br>Aucune nouvelle notification !
      </div>
      <div v-else>
        <div
          v-for="notification in notifications"
          :key="notification.id"
          class="notification-item hover-accent px-2 py-1"
          @click="goTo('/notifications/' + notification.id)"
        >
          <div class="notification-content" v-html="notification.data.html"></div>
          <small class="text-muted">{{ notification.presented_created_at }}</small>
        </div>

        <div class="text-center my-2">
          <a class="btn btn-primary btn-sm" href="/notifications">Voir tout</a>
        </div>
      </div>
    </div>
  </b-dropdown>
</template>

<script>
import $ from "jquery";
import AuthedAxios from "../scripts/axios";

export default {
  props: ["count"],
  data() {
    return {
      loading: true,
      hidden: true,
      notifications: []
    };
  },
  mounted() {
    this.$root.$on("bv::dropdown::show", bvEvent => {
      this.onShow();
    });
    this.$root.$on("bv::dropdown::hide", bvEvent => {
      this.onHide();
    });
  },
  methods: {
    onShow: async function() {
      this.loading = true;
      this.hidden = false;

      let resp = await AuthedAxios.get("notifications");
      this.notifications = resp.data;
      this.loading = false;
    },
    onHide: function() {
      this.hidden = true;
    },
    goTo: function(target) {
      window.location = target;
    }
  }
};
</script>

<style lang="scss">
.notification-dropdown {
  > .btn {
    background: transparent;
    border: 0;

    > span {
      font-size: 1.1em;
    }
  }
}
</style>