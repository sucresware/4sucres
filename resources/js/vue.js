import $ from 'jquery';
import VueClipboard from 'vue-clipboard2';
import VueJS from 'vue';
import BootstrapVue from 'bootstrap-vue'
import vueHljs from "vue-hljs";
import "vue-hljs/dist/vue-hljs.min.css";
import VueHotkey from 'v-hotkey'

class VueWrapper {

    constructor() {
        this.vue = VueJS;
        this.appSelector = '#app';

        this.initialize();
    }

    initialize() {
        let that = this;
        this.loadUserData();

        this.files = require.context('./', true, /\.vue$/i);
        this.files.keys().map(key => this.vue.component(key.split('/').pop().split('.')[0], this.files(key).default));

        this.vue.mixin({
            data: function () {
                return {
                    get auth_user() {
                        return that.user;
                    }
                }
            },
            methods: {
                auth_user_can: function (permission) {
                    return (this.auth_user && this.auth_user.permissions.includes(permission))
                },
                route: route,
            }
        });

        this.vue.use(VueClipboard);
        this.vue.use(BootstrapVue);
        this.vue.use(vueHljs);
        this.vue.use(VueHotkey)

        this.app = new VueJS({
            el: this.appSelector,
        });

    }

    loadUserData() {
        let userMeta = $('meta[name=user-data]');

        if (userMeta.length) {
            this.user = JSON.parse(userMeta.attr('content'));
        }
    }
}

const Vue = new VueWrapper();
export default Vue;
export {
    Vue
};
