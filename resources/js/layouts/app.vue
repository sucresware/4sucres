<template>
  <div class="flex flex-col-reverse w-full h-screen md:flex-row">
    <nav class="flex-none w-16 bg-sidebar-default text-on-sidebar-default">
      <div class="flex flex-row items-center justify-center w-full md:h-full md:flex-col">

        <inertia-link :href="$route('next.home')" class="block p-4 md:w-full">
          <img src="/img/4sucres_inline.png" alt="4sucres.org V2" class="block w-8 mx-auto" />
        </inertia-link>

        <div class="ml-auto md:mt-auto"></div>

        <t-button @click="switch_theme" class="truncate">{{ this.themes[this.selected_theme_index] }}</t-button>

        <t-dropdown variant="sidebar">
          <div slot="trigger" slot-scope="{ mousedownHandler, focusHandler, blurHandler, keydownHandler, }">
            <t-button @mousedown="mousedownHandler" @focus="focusHandler" @blur="blurHandler" @keydown="keydownHandler" variant="sidebar">
              <i class="fas fa-question-circle"></i>
            </t-button>
          </div>

          <div slot-scope="{ blurHandler }">
            <div class="p-4 border-b">
              <div class="mb-1 text-black">
                4sucres.org
                <div class="inline-block px-2 ml-1 text-sm text-white bg-gray-400 rounded-lg" >
                  {{ $page.props.version }}
                </div>
              </div>
              <div class="mb-1">
                Parce qu'à 2 on était pas assez.<br />&copy; 2019-2021
              </div>
              <div class="text-gray-400">
                Temps d'exécution: {{ $page.props.execution_time }}s
              </div>
            </div>

            <div class="p-2">
              <t-button variant="dropdown" @blur="blurHandler">
                Conditions générales d'utilisation
              </t-button>
              <t-button variant="dropdown" @blur="blurHandler">
                Charte d'utilisation
              </t-button>
              <t-button variant="dropdown" target="_blank" href="https://jvflux.fr/4sucres">
                JVFlux
              </t-button>
              <t-button variant="dropdown" target="_blank" href="https://github.com/sucresware/4sucres">
                GitHub
              </t-button>
              <t-button variant="dropdown" target="_blank" href="https://fr.tipeee.com/4sucres">
                Tipeee
              </t-button>
              <t-button variant="dropdown" target="_blank" href="https://discord.me/4sucres">
                Discord
              </t-button>
            </div>
          </div>
        </t-dropdown>

        <t-dropdown v-if="$page.props.user" variant="sidebar">
          <div slot="trigger" slot-scope="{ mousedownHandler, focusHandler, blurHandler, keydownHandler, }">
            <t-button @mousedown="mousedownHandler" @focus="focusHandler" @blur="blurHandler" @keydown="keydownHandler" variant="sidebar">
              <i class="fas fa-bell"></i>
            </t-button>
          </div>

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
          <div slot="trigger" slot-scope="{ mousedownHandler, focusHandler, blurHandler, keydownHandler, }">
            <t-button @mousedown="mousedownHandler" @focus="focusHandler" @blur="blurHandler" @keydown="keydownHandler" variant="sidebar">
              <img
                :src="$page.props.user.avatar_link"
                :alt="$page.props.user.display_name"
                class="w-10 h-10 rounded-md"
              />
            </t-button>
          </div>

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
              <t-button
                :href="$route('profile')"
                @blur="blurHandler"
                variant="dropdown"
              >
                <i class="mr-1 fas fa-user fa-fw"></i> Profil
              </t-button>
              <t-button
                :href="$route('user.settings')"
                @blur="blurHandler"
                variant="dropdown"
              >
                <i class="mr-1 fas fa-cog fa-fw"></i> Paramètres
              </t-button>
              <t-button
                @blur="blurHandler"
                @click="$inertia.post($route('next.logout'))"
                variant="dropdown"
              >
                <i class="mr-1 fas fa-sign-out-alt fa-fw"></i> Déconnexion
              </t-button>
            </div>
          </div>
        </t-dropdown>

        <t-dropdown v-if="!$page.props.user" variant="sidebar">
          <div slot="trigger" slot-scope="{ mousedownHandler, focusHandler, blurHandler, keydownHandler, }">
            <t-button @mousedown="mousedownHandler" @focus="focusHandler" @blur="blurHandler" @keydown="keydownHandler" variant="sidebar">
              <i class="fas fa-power-off"></i>
            </t-button>
          </div>

          <div slot-scope="{ blurHandler }">
            <div class="p-2">
              <t-button
                :href="$route('register')"
                @blur="blurHandler"
                variant="dropdown"
              >
                <i class="fas fa-user-plus fa-fw"></i> Inscription
              </t-button>
              <t-button
                :href="$route('next.login')"
                @blur="blurHandler"
                variant="dropdown"
              >
                <i class="fas fa-power-off fa-fw"></i> Connexion
              </t-button>
            </div>
          </div>
        </t-dropdown>
      </div>
    </nav>

    <slot class="flex-auto"></slot>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        selected_theme_index: 0,
        themes: [
          'arc-light', 'nord-light', 'arc-dark', 'nord-dark',
        ]
      }
    },

    methods: {
      switch_theme(){
        this.selected_theme_index++;
        if (this.selected_theme_index == this.themes.length) this.selected_theme_index = 0;

        document.querySelector('body').setAttribute('data-theme', this.themes[this.selected_theme_index]);
      }
    }
  };
</script>
