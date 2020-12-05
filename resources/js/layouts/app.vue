<template>
  <div class="flex flex-col min-h-screen">
    <nav class="bg-gray-700">
      <div class="flex items-center">
        <inertia-link href="$route('next.home')">
          <img
            src="/svg/logo.svg"
            alt="4sucres.org V2"
            class="inline-block h-8 ml-4"
          />
        </inertia-link>

        <div class="ml-auto"></div>

        <t-dropdown v-if="$page.props.user">
          <div
            slot="trigger"
            slot-scope="{
              mousedownHandler,
              focusHandler,
              blurHandler,
              keydownHandler,
            }"
          >
            <button
              class="flex flex-row items-center p-2 transition duration-150 ease-in-out bg-gray-800 rounded-full hover:bg-gray-900 focus:bg-gray-900 focus:outline-none"
              @mousedown="mousedownHandler"
              @focus="focusHandler"
              @blur="blurHandler"
              @keydown="keydownHandler"
            >
              <i class="fas fa-bell"></i>
            </button>
          </div>

          <div slot-scope="{ blurHandler }" class="p-2 bg-gray-800 rounded">
            <div class="p-4">Notifications</div>

            <button
              class="block w-full px-4 py-2 text-left text-gray-100 transition duration-150 ease-in-out bg-gray-800 rounded hover:bg-gray-900 focus:outline-none focus:bg-gray-900"
              @blur="blurHandler"
            >
              ...<br />
              ...
            </button>
            <button
              class="block w-full px-4 py-2 text-left text-gray-100 transition duration-150 ease-in-out bg-gray-800 rounded hover:bg-gray-900 focus:outline-none focus:bg-gray-900"
              @blur="blurHandler"
            >
              ...<br />
              ...
            </button>
            <button
              class="block w-full px-4 py-2 text-left text-gray-100 transition duration-150 ease-in-out bg-gray-800 rounded hover:bg-gray-900 focus:outline-none focus:bg-gray-900"
              @blur="blurHandler"
            >
              ...<br />
              ...
            </button>
          </div>
        </t-dropdown>

        <t-dropdown v-if="$page.props.user">
          <div
            slot="trigger"
            slot-scope="{
              mousedownHandler,
              focusHandler,
              blurHandler,
              keydownHandler,
            }"
          >
            <button
              class="flex flex-row items-center h-16 px-4 ml-4 transition duration-150 ease-in-out bg-gray-800 hover:bg-gray-900 focus:bg-gray-900 focus:outline-none"
              @mousedown="mousedownHandler"
              @focus="focusHandler"
              @blur="blurHandler"
              @keydown="keydownHandler"
            >
              <img
                :src="$page.props.user.avatar_link"
                :alt="$page.props.user.display_name"
                class="w-10 h-10 mr-4 rounded"
              />
              <div class="flex flex-col items-start justify-center h-16">
                <div>{{ $page.props.user.display_name }}</div>
                <div class="text-sm text-gray-400">
                  {{ $page.props.user.shown_role }}
                </div>
              </div>
            </button>
          </div>

          <div slot-scope="{ blurHandler }" class="p-2 bg-gray-800 rounded">
            <inertia-link
              class="block w-full px-4 py-2 text-left text-gray-100 transition duration-150 ease-in-out bg-gray-800 rounded hover:bg-gray-900 focus:outline-none focus:bg-gray-900"
              :href="$route('user.settings')"
              @blur="blurHandler"
            >
              <i class="mr-1 fas fa-cog fa-fw"></i> Paramètres
            </inertia-link>
            <button
              class="block w-full px-4 py-2 text-left text-gray-100 transition duration-150 ease-in-out bg-gray-800 rounded hover:bg-gray-900 focus:outline-none focus:bg-gray-900"
              @blur="blurHandler"
              @click="$inertia.post($route('next.logout'))"
            >
              <i class="mr-1 fas fa-sign-out-alt fa-fw"></i> Déconnexion
            </button>
          </div>
        </t-dropdown>

        <div
          v-if="!$page.props.user"
          class="flex flex-row items-center h-16 px-4 ml-4 transition duration-150 ease-in-out bg-gray-800"
        >
          <t-button :href="$route('register')" variant="link"
            ><i class="mr-1 fas fa-user-plus"></i> Inscription</t-button
          >
          <t-button :href="$route('next.login')" variant="link"
            ><i class="mr-1 fas fa-power-off"></i> Connexion</t-button
          >
        </div>
      </div>
    </nav>

    <slot class="flex-grow"></slot>
  </div>
</template>

<script>
export default {};
</script>
