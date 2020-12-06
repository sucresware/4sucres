<template>
  <div class="flex flex-row w-full">
    <div
      class="flex flex-col w-full h-screen border-r bg-gray-50 md:border-r md:block md:w-1/2 lg:w-1/3"
      :class="{ 'hidden md:flex': show_discussion }"
      >
      <div class="p-4 border-b">
        <div class="flex flex-row items-center">
          <div class="mr-auto text-xl">Discussions</div>
          <paginator :paginator="_.omit(discussions, 'data')" :only="['discussions']" />
          <t-button @click="reload" class="ml-2"><i class="fas fa-sync"></i></t-button>
        </div>
        <!-- <t-button v-if="$page.props.user && $page.props.user.permissions.includes('create discussions')" :href="$route('discussions.create')"><i class="fas fa-plus"></i></t-button> -->
      </div>
      <div class="flex-grow p-2" scroll-region>
        <div
          v-for="item in discussions.data"
          class="px-2 py-4 transition duration-150 ease-in-out rounded-md hover:bg-gray-100 focus:outline-none focus:bg-gray-200"
          :key="item.id"
          :class="{ 'bg-gray-200': (show_discussion && discussion && item.id == discussion.id) }"
        >
          <div class="flex items-center">
            <div class="flex-grow truncate">
              <div class="pr-2 truncate">
                <inertia-link
                  :href="$route('next.discussions.show', [item.id, item.slug])"
                  :only="['discussion']"
                  preserve-scroll
                  class="font-bold">
                  <i
                    class="mr-1 text-sm truncate text-brand fas fa-circle"
                    :class="{'hidden': ($page.props.user && !item.has_seen)}" />
                  {{ item.title }}
                </inertia-link>
              </div>
              <div class="text-sm">
                <inertia-link :href="$route('user.show', item.user.name)">{{ item.user.display_name }}</inertia-link>
                -
                {{ item.replies }} réponses
              </div>
            </div>
            <div class="flex-shrink-0">
              <inertia-link :href="$route('posts.show', item.latest_post.id)">
                {{ moment(item.latest_post.created_at).fromNow().replace('il y a ', '') }}
              </inertia-link>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full min-h-screen md:block md:w-1/2 lg:w-2/3" v-if="show_discussion && discussion">
      <div class="p-4 border-b">
        <div class="flex flex-row items-center">
          <t-button @click="blur" class="mr-2"><i class="fas fa-arrow-left"></i></t-button>
          <div class="mr-auto text-xl">{{ discussion.title }}</div>
          <paginator :paginator="_.omit(discussion.posts, 'data')" :only="['discussion']" />
          <template v-if="$page.props.user">
            <t-button href="#" class="ml-2"><i class="fas fa-plus"></i></t-button>
            <t-button :href="$route('discussions.unsubscribe', [discussion.id, discussion.slug])" class="ml-2"><i class="fas fa-star"></i></t-button>
          </template>
          <t-button @click="reload" class="ml-2"><i class="fas fa-sync"></i></t-button>
        </div>
      </div>
      <div class="flex-grow p-2" scroll-region>
        <div
          v-for="post in discussion.posts.data"
          :key="post.id"
          class="px-2 py-4 bg-white rounded-md"
        >
          <div class="flex-1 border-b border-body-border">
            <div class="flex items-center px-6 py-4 bg-body-variant text-on-body-variant">
              <!-- <user-avatar :user="post.user" class="mr-4" /> -->
              <div>
                <!-- <user-name :user="post.user" /> -->
                <br>
                <inertia-link :href="post.link" class="text-sm">
                  {{ moment(post.created_at).format('L') }} {{ moment(post.created_at).format('LTS') }}
                  <span v-if="post.created_at != post.updated_at">
                    (modifié, {{ moment(post.updated_at).calendar() }})
                  </span>
                </inertia-link>
              </div>
              <div class="ml-auto">
                <popper trigger="click" :options="{ placement: 'right-end', modifiers: {preventOverflow :{ boundariesElement: 'window'  }}}">
                  <div class="popper">
                    <ul>
                      <li><i class="fal fa-quote-left"></i> Citer</li>
                      <template v-if="$page.props.user">
                        <li>
                          <inertia-link
                            v-if="$page.props.user.id == post.user.id || $page.props.user.permissions.includes('bypass discussions guard')"
                            :href="route('discussions.posts.edit', [discussion.id, discussion.slug, post.id])"
                            class="btn btn-sm btn-tertiary">
                              <i class="fal fa-edit"></i> Modifier
                          </inertia-link>
                        </li>
                        <li>
                          <inertia-link
                            v-if="$page.props.user.id == post.user.id || $page.props.user.permissions.includes('bypass discussions guard')"
                            :href="route('discussions.posts.delete', [discussion.id, discussion.slug, post.id])"
                            class="btn btn-sm btn-tertiary">
                            <i class="fal fa-trash"></i> Supprimer
                          </inertia-link>
                        </li>
                      </template>
                    </ul>
                  </div>
                  <button slot="reference">
                    <action-button type="tertiary">
                      <i class="fas fa-ellipsis-h"></i>
                    </action-button>
                  </button>
                </popper>
              </div>
            </div>
            <hr class="border-body-border">
            <div class="p-6">
              <div class="user-content" v-html="post.presented_body"  v-if="!post.deleted_at" />
              <div v-else><i class="mr-1 fal fa-times"></i> Ce message a été supprimé</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full min-h-screen overflow-y-auto md:block md:w-1/2 lg:w-2/3" v-else>
      <div class="flex items-center justify-center h-screen">
        <img src="/img/4sucres_white_white.png" alt="4sucres.org">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: require("../../layouts/app").default,

  props: {
    discussions: Object,
    discussion: Object,
  },

  data() {
    return {
      show_discussion: false,
    }
  },

  mounted() {
    this.show_discussion = this.discussion ? true : false;
  },

  methods: {
    blur(){
      this.show_discussion = false;
    },
    select(discussion){
      this.selectedDiscussionId = discussion.id;
      this.$inertia.visit(
        route('discussions.show', [discussion.id, discussion.slug]),
        {
          preserveScroll: true,
          only: ['discussion']
        }
      );
    },
    reload() {
      this.$inertia.reload({ preserveScroll: true });
    },
  }
};
</script>
