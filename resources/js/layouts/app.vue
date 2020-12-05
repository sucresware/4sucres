<template>
  <div class="flex flex-row min-h-screen">
    <nav class="bg-gray-700">
      <div class="flex flex-col min-h-screen">
        <inertia-link :href="$route('next.home')" class="block w-full p-4">
          <img
            src="/img/4sucres_inline.png"
            alt="4sucres.org V2"
            class="block w-8 mx-auto"
          />
        </inertia-link>

        <div class="mt-auto"></div>

        <t-dropdown variant="sidebar">
          <div
            slot="trigger"
            slot-scope="{
              mousedownHandler,
              focusHandler,
              blurHandler,
              keydownHandler,
            }"
          >
            <t-button
              @mousedown="mousedownHandler"
              @focus="focusHandler"
              @blur="blurHandler"
              @keydown="keydownHandler"
              variant="sidebar"
            >
              <i class="fas fa-question-circle"></i>
            </t-button>
          </div>

          <div slot-scope="{ blurHandler }">
            <div class="p-4 border-b">
              <div class="mb-1 text-black">
                4sucres.org
                <div
                  class="inline-block px-2 ml-1 text-sm text-white bg-gray-400 rounded-lg"
                >
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
              <t-button variant="dropdown" @blur="blurHandler">
                JVFlux
              </t-button>
              <t-button variant="dropdown" @blur="blurHandler">
                GitHub
              </t-button>
              <t-button variant="dropdown" @blur="blurHandler">
                Tipeee
              </t-button>
              <t-button variant="dropdown" @blur="blurHandler">
                Discord
              </t-button>
            </div>
          </div>
        </t-dropdown>

        <t-dropdown v-if="$page.props.user" variant="sidebar">
          <div
            slot="trigger"
            slot-scope="{
              mousedownHandler,
              focusHandler,
              blurHandler,
              keydownHandler,
            }"
          >
            <t-button
              @mousedown="mousedownHandler"
              @focus="focusHandler"
              @blur="blurHandler"
              @keydown="keydownHandler"
              variant="sidebar"
            >
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
          <div
            slot="trigger"
            slot-scope="{
              mousedownHandler,
              focusHandler,
              blurHandler,
              keydownHandler,
            }"
          >
            <t-button
              @mousedown="mousedownHandler"
              @focus="focusHandler"
              @blur="blurHandler"
              @keydown="keydownHandler"
              variant="sidebar"
            >
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

        <template v-if="!$page.props.user">
          <t-button
            :href="$route('register')"
            @mousedown="mousedownHandler"
            @focus="focusHandler"
            @blur="blurHandler"
            @keydown="keydownHandler"
            variant="sidebar"
          >
            <i class="fas fa-user-plus"></i>
          </t-button>

          <t-button
            :href="$route('next.login')"
            @mousedown="mousedownHandler"
            @focus="focusHandler"
            @blur="blurHandler"
            @keydown="keydownHandler"
            variant="sidebar"
          >
            <i class="fas fa-power-off"></i>
          </t-button>
        </template>
      </div>
    </nav>

    <slot class="flex-grow"></slot>
  </div>
</template>

<script>
export default {};
</script>
