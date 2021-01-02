<template>
  <div class="flex flex-col-reverse w-full vh md:flex-row">
    <nav
      class="flex-none h-16 border-t md:h-auto md:w-16 md:border-t-0 md:border-r bg-sidebar-default text-on-sidebar-default border-on-background-border"
    >
      <div class="flex flex-row items-center w-full h-full md:flex-col">
        <inertia-link
          :href="$route('next.home')"
          class="flex items-center justify-center w-16 h-full md:h-16 md:w-full bg-accent-default text-on-accent-default md:px-0"
        >
          <logo class="w-10 mx-auto focus:outline-none" />
        </inertia-link>

        <div class="flex-grow"></div>

        <t-button variant="sidebar" @click="switchTheme"><i class="fas fa-palette"></i></t-button>

        <t-dropdown variant="sidebar">
          <t-button
            @mousedown="mousedownHandler"
            @focus="focusHandler"
            @blur="blurHandler"
            @keydown="keydownHandler"
            variant="sidebar"
            slot="trigger"
            slot-scope="{ mousedownHandler, focusHandler, blurHandler, keydownHandler }"
          >
            <i class="fas fa-question-circle"></i>
          </t-button>

          <div slot-scope="{ blurHandler }">
            <div class="p-4 border-b">
              <div class="mb-1 text-black">
                4sucres.org
                <div class="inline-block px-2 ml-1 text-sm text-white bg-gray-400 rounded-lg">
                  {{ $page.props.version }}
                </div>
              </div>
              <div class="mb-1">Parce qu'à 2 on était pas assez.<br />&copy; 2019-2021</div>
              <div class="text-gray-400">Temps d'exécution: {{ $page.props.execution_time }}s</div>
            </div>

            <div class="p-2">
              <t-button variant="dropdown" @blur="blurHandler"> Conditions générales d'utilisation </t-button>
              <t-button variant="dropdown" @blur="blurHandler"> Charte d'utilisation </t-button>
              <t-button variant="dropdown" target="_blank" href="https://jvflux.fr/4sucres"> JVFlux </t-button>
              <t-button variant="dropdown" target="_blank" href="https://github.com/sucresware/4sucres">
                GitHub
              </t-button>
              <t-button variant="dropdown" target="_blank" href="https://fr.tipeee.com/4sucres"> Tipeee </t-button>
              <t-button variant="dropdown" target="_blank" href="https://discord.me/4sucres"> Discord </t-button>
            </div>
          </div>
        </t-dropdown>

        <t-dropdown v-if="$page.props.user" variant="sidebar">
          <t-button
            @mousedown="mousedownHandler"
            @focus="focusHandler"
            @blur="blurHandler"
            @keydown="keydownHandler"
            variant="sidebar"
            slot="trigger"
            slot-scope="{ mousedownHandler, focusHandler, blurHandler, keydownHandler }"
          >
            <i class="fas fa-bell"></i>
          </t-button>

          <div slot-scope="{ blurHandler }">
            <div class="p-4 border-b">Notifications</div>

            <div class="p-2">
              <t-button variant="dropdown" @blur="blurHandler">
                ...<br />
                ...
              </t-button>
              <t-button variant="dropdown" @blur="blurHandler">
                ...<br />
                ...
              </t-button>
            </div>
          </div>
        </t-dropdown>

        <t-dropdown v-if="$page.props.user" variant="sidebar">
          <t-button
            @mousedown="mousedownHandler"
            @focus="focusHandler"
            @blur="blurHandler"
            @keydown="keydownHandler"
            variant="sidebar"
            slot="trigger"
            slot-scope="{ mousedownHandler, focusHandler, blurHandler, keydownHandler }"
          >
            <img
              :src="$page.props.user.avatar_link"
              :alt="$page.props.user.display_name"
              class="w-10 h-10 rounded-md"
            />
          </t-button>

          <div slot-scope="{ blurHandler }">
            <div class="flex flex-row p-4 border-b">
              <img
                :src="$page.props.user.avatar_link"
                :alt="$page.props.user.display_name"
                class="w-10 h-10 mr-4 rounded-md"
              />
              <div class="flex flex-col items-start justify-center">
                <div>{{ $page.props.user.display_name }}</div>
                <div class="text-sm text-gray-400">
                  {{ $page.props.user.shown_role }}
                </div>
              </div>
            </div>
            <div class="p-2">
              <t-button :href="$route('profile')" @blur="blurHandler" variant="dropdown">
                <i class="mr-1 fas fa-user fa-fw"></i> Profil
              </t-button>
              <t-button :href="$route('user.settings')" @blur="blurHandler" variant="dropdown">
                <i class="mr-1 fas fa-cog fa-fw"></i> Paramètres
              </t-button>
              <t-button @blur="blurHandler" @click="$inertia.post($route('next.logout'))" variant="dropdown">
                <i class="mr-1 fas fa-sign-out-alt fa-fw"></i> Déconnexion
              </t-button>
            </div>
          </div>
        </t-dropdown>

        <t-dropdown v-if="!$page.props.user" variant="sidebar">
          <t-button
            @mousedown="mousedownHandler"
            @focus="focusHandler"
            @blur="blurHandler"
            @keydown="keydownHandler"
            variant="sidebar"
            slot="trigger"
            slot-scope="{ mousedownHandler, focusHandler, blurHandler, keydownHandler }"
          >
            <i class="fas fa-power-off"></i>
          </t-button>

          <div slot-scope="{ blurHandler }">
            <div class="p-2">
              <t-button :href="$route('register')" @blur="blurHandler" variant="dropdown">
                <i class="fas fa-user-plus fa-fw"></i> Inscription
              </t-button>
              <t-button :href="$route('next.login')" @blur="blurHandler" variant="dropdown">
                <i class="fas fa-power-off fa-fw"></i> Connexion
              </t-button>
            </div>
          </div>
        </t-dropdown>
      </div>
    </nav>
    <div class="flex-auto">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
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
    switchTheme() {
      this.selectedThemeIndex++;
      if (this.selectedThemeIndex == this.themes.length) this.selectedThemeIndex = 0;

      document.querySelector('html').setAttribute('data-theme', this.themes[this.selectedThemeIndex]);
      localStorage.theme = this.themes[this.selectedThemeIndex];
    },
  },
};
</script>
