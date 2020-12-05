import "./bootstrap"
import Vue from "vue"
import { InertiaApp } from "@inertiajs/inertia-vue"
import VueTailwind from 'vue-tailwind'
import settings from './theme.base.js'

Vue.use(VueTailwind, settings)

Vue.use(InertiaApp)

Vue.prototype.$route = route

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const app = document.getElementById('app')

new Vue({
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => require(`./pages/${name}`).default,
        },
    }),
}).$mount(app)
