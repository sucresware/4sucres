<template>
  <div class="console">
    <div class="content shadow" id="content">
      <div v-for="line in lines" v-bind:key="line.index" v-html="line" class="output"></div>
    </div>
    <div class="prompt">
      <input
        type="text"
        v-model="command"
        class="form-control"
        v-hotkey="keymap"
        v-on:keyup.enter="run()"
      />
      <div class="loading-indicator" v-show="loading">
        <i class="fas fa-circle-notch fa-spin"></i>
      </div>
    </div>
  </div>
</template>

<script>
import $ from "jquery";
import AuthedAxios from "../scripts/axios";

export default {
  data: () => {
    return {
      command: "",
      loading: false,
      lines: []
    };
  },
  methods: {
    run(command) {
      let vm = this;
      command = command ? command : this.command;

      if (!command) return;

      this.lines.push('<span class="text-muted">›</span> ' + command);
      this.loading = true;

      AuthedAxios.get(command)
        .then(resp => {
          vm.lines.push(resp.data.output + "<br><br>");
        })
        .catch(error => {
          vm.lines.push(error);
        })
        .finally(() => {
          vm.scroll();
          vm.loading = false;
        });
      this.command = "";
    },
    scroll() {
      var content = this.$el.querySelector("#content");
      content.scrollTop = content.scrollHeight;
    },
    clear() {
      this.lines = [];
      var content = this.$el.querySelector("#content");
      content.focus();
    }
  },
  mounted() {
    AuthedAxios.defaults.baseURL = "/admin/console/run/";
    this.run("help");
  },
  computed: {
    keymap() {
      return {
        "ctrl+shift+l": this.clear
      };
    }
  }
};
</script>