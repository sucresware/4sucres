<template>
  <div>
    <div
      :class="{
        'p-1': true,
        'text-white bg-danger': activity.properties && (activity.properties.level == 'critical' || activity.properties.level == 'alert' || activity.properties.level == 'emergency'),
        'text-white bg-warning': activity.properties && activity.properties.level == 'warning'
      }"
    >
      <div class="row">
        <div class="col-sm-auto">
          <i :class="levelClass()"></i>
          <i
            :class="{
            'fas fa-fw text-success' : true,
            'fa-lock' : activity.properties && activity.properties.elevated
          }"
          ></i>
        </div>
        <div class="col-sm text-monospace">{{ activity.created_at }}</div>
        <div class="col-sm">{{ description() }}</div>
        <div class="col-sm">
          <a :href="subject().link">{{ subject().markup }}</a>
        </div>
        <div class="col-sm">
          <a href="#" v-on:click="openPropertiesModal()">
            <i class="fas fa-list"></i>
          </a>
        </div>
        <div class="col-sm">
          <template v-if="activity.causer">
            <a :href="activity.causer.link" target="_blank">
              <i class="fas fa-user fa-fw"></i>
              {{ activity.causer.name }}
            </a>
          </template>
          <template v-else>
            <i class="fas fa-user-times fa-fw"></i>
            Inconnu
          </template>
        </div>
      </div>
    </div>

    <div class="modal fade" :id="'properties-' + activity.id" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Propriétés</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <pre><code class="json">{{ activity.properties }}</code></pre>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import $ from "jquery";

export default {
  props: ["activity"],
  methods: {
    levelClass() {
      if (this.activity.properties && this.activity.properties.level) {
        switch (this.activity.properties.level) {
          case "alert":
          case "emergency":
            return ["fas", "fa-exclamation-circle", "fa-blink"];
          case "critical":
            return ["fas", "fa-exclamation-triangle", "text-danger"];
          case "error":
            return ["fas", "fa-square", "text-danger"];
          case "warning":
            return ["fas", "fa-square", "text-warning"];
          case "notice":
            return ["fas", "fa-square", "text-primary"];
          case "info":
          default:
            return ["fas", "fa-square", "text-muted"];
        }
      } else {
        switch (this.activity.description) {
          case "deleted":
          case "created":
          case "updated":
            return ["fa", "fa-square", "text-primary"];
          default:
            return ["fa", "fa-square", "text-muted"];
        }
      }
    },
    openPropertiesModal() {
      $("#properties-" + this.activity.id).modal("toggle");
    },
    description() {
      if (
        this.activity.description == "created" ||
        this.activity.description == "updated" ||
        this.activity.description == "deleted"
      ) {
        let markup = this.subject(this.activity).markup;
        let description = this.activity.description;
        return markup + description[0].toUpperCase() + description.substring(1);
      } else {
        return this.activity.description;
      }
    },
    subject() {
      let markup, link;

      switch (this.activity.subject_type) {
        case "App\\Models\\Post":
          markup = "Post";
          link = "/p/" + this.activity.subject_id;
          break;
        case "App\\Models\\Discussion":
          markup = "Discussion";
          link = "/d/" + this.activity.subject_id + "-log";
          break;
        case "App\\Models\\User":
          markup = "User";
          link = "/u/" + this.activity.subject_id;
          break;
        default:
          markup = this.activity.subject_type;
          break;
      }
      return {
        markup: markup,
        link: link
      };
    }
  }
};
</script>