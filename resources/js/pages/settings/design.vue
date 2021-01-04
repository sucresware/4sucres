<template>
  <div
    class="w-full h-full p-4 overflow-y-auto scrollbar-thin bg-toolbar-default text-on-toolbar-default scrollbar-track-toolbar-default scrollbar-thumb-on-toolbar-border hover:scrollbar-thumb-on-toolbar-border"
    scroll-region
  >
    <div class="container">
      <subnav-settings class="mb-8" />
      <alerts class="mb-8" />

      <h1 class="mb-4 text-lg font-semibold">Thème</h1>

      <div class="grid grid-cols-1 gap-4 lg:grid-cols-4 sm:grid-cols-2 xl:grid-cols-5">
        <div
          class="h-32 mb-6 cursor-pointer"
          :data-theme="themes[i - 1]"
          v-for="i in themes.length"
          v-bind:key="i - 1"
          @click="setTheme(i - 1)"
        >
          <span class="block mb-2 text-sm font-semibold">{{ themes[i - 1] }}</span>
          <div class="flex flex-row w-full h-full shadow">
            <div class="flex flex-col flex-none w-4 border-r bg-sidebar-default border-on-background-border">
              <div class="flex items-center justify-center flex-none h-4 bg-accent-default">
                <logo class="w-2 h-2 text-on-accent-default" />
              </div>
              <div class="flex-auto"></div>
              <div class="flex items-center justify-center flex-none h-2 bg-on-sidebar-button-background-hover">
                <div class="w-1 h-1 rounded-lg bg-on-accent-default"></div>
              </div>
              <div class="flex items-center justify-center flex-none h-2 bg-on-sidebar-button-background ">
                <div class="w-1 h-1 rounded-lg bg-on-accent-default"></div>
              </div>
            </div>
            <div class="flex flex-col flex-none w-16 border-r bg-toolbar-default border-on-background-border">
              <div class="h-4 border-b border-on-background-border"></div>
              <div class="flex items-center h-4 px-1 border-b border-on-background-border bg-toolbar-selected">
                <div class="w-4 h-px bg-on-toolbar-selected"></div>
              </div>
              <div class="flex items-center h-4 px-1 border-b border-on-background-border bg-toolbar-hover">
                <div class="w-2 h-px bg-on-toolbar-default"></div>
              </div>
              <div class="flex items-center h-4 px-1 border-b border-on-background-border">
                <div class="w-6 h-px bg-on-toolbar-default"></div>
              </div>
              <div class="h-4 border-b border-on-background-border"></div>
            </div>
            <div class="flex flex-col flex-auto bg-background-default">
              <div class="h-4 border-b border-on-background-border"></div>
              <div class="flex flex-row p-1 mb-1">
                <div class="flex-none w-2 h-2 mr-1 rounded-avatar bg-on-background-border"></div>
                <div class="flex flex-row items-start flex-auto">
                  <div class="block w-2 h-px mr-1 bg-on-background-default"></div>
                  <div class="block w-4 h-px mr-1 bg-on-background-default"></div>
                  <div class="block w-1 h-px mr-1 bg-on-background-default"></div>
                  <div class="block w-2 h-px mr-1 bg-on-background-default"></div>
                </div>
              </div>
              <div class="flex flex-row p-1 mb-1">
                <div class="flex-none w-2 h-2 mr-1 rounded-avatar bg-on-background-border"></div>
                <div class="flex flex-row items-start flex-auto">
                  <div class="block w-4 h-px mr-1 bg-on-background-default"></div>
                  <div class="block w-2 h-px mr-1 bg-on-background-default"></div>
                  <div class="block w-2 h-px mr-1 bg-on-background-default"></div>
                  <div class="block w-2 h-px mr-1 bg-on-background-default"></div>
                  <div class="block w-1 h-px mr-1 bg-on-background-default"></div>
                </div>
              </div>
              <div class="flex flex-row p-1 mb-1">
                <div class="flex-none w-2 h-2 mr-1 rounded-avatar bg-on-background-border"></div>
                <div class="flex flex-row items-start flex-auto">
                  <div class="block w-1 h-px mr-1 bg-on-background-default"></div>
                  <div class="block w-2 h-px mr-1 bg-on-background-default"></div>
                  <div class="block w-4 h-px mr-1 bg-on-background-default"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: require('../../layouts/app').default,

  props: ['theme_overrides'],

  data() {
    return {
      selectedThemeIndex: 0,
      themes: [
        'sucresware-light',
        'arc-light',
        'dracula-light',
        'gruvbox-light',
        'monokai-pro-light',
        'nord-light',
        'primer-light',
        'solarized-light',
        'twitch-light',
        'yaru-light',
        // 'sucresware-dark',
        'arc-dark',
        'dracula-dark',
        'gruvbox-dark',
        'monokai-pro-dark',
        'nord-dark',
        'primer-dark',
        'solarized-dark',
        'twitch-dark',
        'yaru-dark',
      ],
    };
  },

  mounted() {
    let selectedTheme = document.querySelector('html').getAttribute('data-theme');
    this.selectedThemeIndex = _.findIndex(this.themes, (v) => v == selectedTheme);
  },

  methods: {
    setTheme(index) {
      document.querySelector('html').setAttribute('data-theme', this.themes[index]);
      localStorage.theme = this.themes[index];
    },
  },
};
</script>
