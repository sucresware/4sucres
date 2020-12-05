import "./bootstrap";
import Vue from "vue";

import { App, plugin } from '@inertiajs/inertia-vue'
Vue.use(plugin)

import VueTailwind from "vue-tailwind";
import settings from "./theme.base.js";
Vue.use(VueTailwind, settings);

Vue.prototype.$route = route;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context("./", true, /\.vue$/i);
files.keys().map(key => {
    // Only load lowercased files (workaround)
    let letter = key.split('/').pop().split('.')[0][0];
    if (letter === letter.toLowerCase()) Vue.component(key.split('/').pop().split('.')[0], files(key).default)
})

const el = document.getElementById('app')

new Vue({
  render: h => h(App, {
    props: {
      initialPage: JSON.parse(el.dataset.page),
      resolveComponent: name => require(`./pages/${name}`).default,
    },
  }),
}).$mount(el)