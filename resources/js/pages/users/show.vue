<template>
  <div class="w-full h-full my-4">
    <div class="container">
      <t-card>
        <div class="flex flex-row items-center">
          <div class="flex-none mr-4 w-avatar-xl">
            <img :src="user.avatar_link" :alt="user.name" class="rounded-avatar" />
          </div>
          <div class="flex-auto overflow-auto">
            <inertia-link @click.stop="" :href="$route('next.users.show', user.name)">
              <span class="text-muted">/u/{{ user.name }}</span>
              <h1 class="text-lg">
                {{ user.display_name }}
              </h1>
            </inertia-link>
          </div>
        </div>
      </t-card>
    </div>
  </div>
</template>

<script>
export default {
  layout: require('../../layouts/app').default,

  props: {
    user: Object,
  },

  data() {
    return {};
  },

  mounted() {},

  methods: {},
};
</script>
