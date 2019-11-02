import { VueConstructor } from 'vue';
import { Layout } from './layout';
import { Router } from '@/Script/router';
import { Meta } from '@/Script/meta';
import { Theme } from '@/Script/theme';

import RegisterFontAwesome from '@/Script/font-awesome';
import RegisterRouteGuards from '@/Script/router/guard';

import Ripple from 'vue-ripple-directive';
import Lang from 'laravel-vue-lang';
import Tooltip from 'v-tooltip';

export const Adapters = {
  install: (Vue: VueConstructor) => {
    RegisterFontAwesome(Vue);
    RegisterRouteGuards(Vue);

    Vue.mixin(Router);
    Vue.mixin(Meta);
    Vue.mixin(Layout);
    Vue.mixin(Theme);

    Vue.use(Lang);
    Vue.use(Tooltip);

    Ripple.color = 'rgba(var(--overlay), var(--overlay-pressed))';
    Vue.directive('ripple', Ripple);
  },
};

declare module 'vue/types/vue' {
  interface Vue {
    $page?: any;
  }
}
