<template>
  <div>
    <div
      :class="{
        'bg-danger': activity.properties
            && (activity.properties.level == 'critical'
                || activity.properties.level == 'alert'
                || activity.properties.level == 'emergency'),
        'bg-warning': activity.properties
            && activity.properties.level == 'warning'
      }"
    >
      <div class="row align-items-center no-gutters text-monospace">
        <div class="col-sm-auto p-1">
          <i :class="levelClass()"></i>
          <i
            :class="{
            'fas fa-fw text-success' : true,
            'fa-lock' : activity.properties && activity.properties.elevated
          }"
          ></i>
        </div>
        <div class="col-sm">{{ activity.created_at }}</div>
        <div class="col-sm">{{ description() }}</div>
        <div class="col-sm">
          <button
            class="btn btn-link btn-sm"
            v-b-toggle="'context-' + activity.id"
          >{{ subject().markup }}</button>
        </div>
        <div class="col-sm">
          <template v-if="activity.causer">
            <a :href="activity.causer.link" target="_blank">
              <i class="fas fa-user"></i>
              {{ activity.causer.name }}
            </a>
          </template>
          <template v-else>
            <i class="fas fa-user-times"></i>
            Inconnu
          </template>
        </div>
        <b-collapse :id="'context-' + activity.id" class="col-12">
          <div class="card border-bottom border-top">
            <div class="card-body">
              <a
                :href="subject().link"
                target="_blank"
              >{{ activity.subject_type }} - {{ activity.subject_id }}</a>
              <hr>
              <pre>{{ activity.properties }}</pre>
            </div>
          </div>
        </b-collapse>
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
          case "emergency":
          case "critical":
            return ["fas", "fa-exclamation-circle", "fa-blink"];
          case "alert":
            return ["fas", "fa-exclamation-circle"];
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
            return ["fas", "fa-circle", "text-primary"];
          default:
            return ["fas", "fa-circle", "text-muted"];
        }
      }
    },
    openContext() {
      $("#context-" + this.activity.id).collapse("toggle");
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
      let markup, link, type;

      switch (this.activity.subject_type) {
        case "App\\Models\\Post":
          type = "Post";
          link = "/p/" + this.activity.subject_id;
          break;
        case "App\\Models\\Discussion":
          type = "Discussion";
          link = "/d/" + this.activity.subject_id + "-fromLogs";
          break;
        case "App\\Models\\User":
          type = "User";
          link = "/u/" + this.activity.subject_id;
          break;
        default:
          type = this.activity.subject_type;
          break;
      }

      if (!markup) markup = type;

      return {
        type: type,
        markup: markup,
        link: link
      };
    }
  }
};
</script>