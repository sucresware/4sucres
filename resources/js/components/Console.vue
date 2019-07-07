<template>
  <div class="console">
    <div class="content shadow" id="content">
      <div v-for="line in lines" v-bind:key="line.index" v-html="line" class="output"></div>
    </div>
    <div class="prompt">
      <input type="text" v-model="command" class="form-control" v-on:keyup.enter="run()" />
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
      this.loading = true;

      AuthedAxios.get(command ? command : this.command)
        .then(resp => {
          vm.lines.push(resp.data.output);
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
    }
  },
  mounted() {
    AuthedAxios.defaults.baseURL = "/admin/console/run/";
    this.run("help");
  }
};
</script>