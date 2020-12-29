<template>
  <div class="flex flex-row w-full h-full min-h-0">
    <div class="flex flex-col w-full md:w-1/2 lg:w-1/3" :class="{ 'hidden md:flex': show_discussion }">
      <div class="flex-none p-4 bg-toolbar-default text-on-toolbar-default">
        <div class="flex flex-row items-center">
          <div class="mr-auto text-xl">Discussions</div>
          <paginator :paginator="_.omit(discussions, 'data')" :only="['discussions']" />
          <t-button @click="reload" class="ml-2" variant="secondary"><i class="fas fa-sync"></i></t-button>
        </div>
        <!-- <t-button v-if="$page.props.user && $page.props.user.permissions.includes('create discussions')" :href="$route('discussions.create')"><i class="fas fa-plus"></i></t-button> -->
      </div>
      <div class="flex-auto overflow-y-auto" scroll-region>
        <div
          v-for="item in discussions.data"
          class="px-4 py-3 duration-150 transition-background hover:bg-background-hover focus:bg-background-active"
          :key="item.id"
          :class="{ 'bg-background-selected text-on-background-selected hover:bg-background-selected hover:text-on-background-selected': (show_discussion && discussion && item.id == discussion.id) }"
        >
          <div class="flex items-center">
            <div class="flex-grow truncate">
              <div class="pr-2 truncate">
                <inertia-link
                  :href="$route('next.discussions.show', [item.id, item.slug])"
                  :only="['discussion']"
                  preserve-scroll
                  class="font-bold">
                  <!-- <i
                    class="mr-1 text-sm text-brand fas fa-circle"
                    :class="{'hidden': ($page.props.user && !item.has_seen)}" /> -->
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
    <div class="flex flex-col w-full md:w-1/2 lg:w-2/3" v-if="show_discussion && discussion">
      <div class="p-4 bg-toolbar-default text-on-toolbar-default">
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
      <div class="flex-grow p-2 overflow-y-auto" scroll-region>
        <div
          v-for="post in discussion.posts.data"
          :key="post.id"
          class="px-2 py-4 bg-white rounded-md"
        >
          <div class="flex-1 border-b border-on-background-border">
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
                            :href="$route('discussions.posts.edit', [discussion.id, discussion.slug, post.id])"
                            class="btn btn-sm btn-tertiary">
                              <i class="fal fa-edit"></i> Modifier
                          </inertia-link>
                        </li>
                        <li>
                          <inertia-link
                            v-if="$page.props.user.id == post.user.id || $page.props.user.permissions.includes('bypass discussions guard')"
                            :href="$route('discussions.posts.delete', [discussion.id, discussion.slug, post.id])"
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
            <hr class="border-on-background-border">
            <div class="p-6">
              <div class="user-content" v-html="post.presented_body"  v-if="!post.deleted_at" />
              <div v-else><i class="mr-1 fal fa-times"></i> Ce message a été supprimé</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="flex items-center justify-center hidden w-full overflow-y-auto md:flex bg-gradient-to-t from-gray-50 to-gray-100 md:w-1/2 lg:w-2/3" v-else>
      <svg class="block w-48 mx-auto opacity-25 fill-current" viewBox="0 0 36 28" xmlns="http://www.w3.org/2000/svg">
        <path d="M22.5474 4.80023L33.3081 4.80023L35.0157 10.8558L28.0235 23.9102L20.0876 23.9102L20.2065 22.8424L22.4128 21.7594L23.3066 15.779L22.7141 15.1637L21.4974 15.1637L22.3432 8.79223L21.8897 8.27744L20.5493 8.27744L22.5474 4.80023Z" fill="currentColor"/>
        <path d="M12.0384 26L12.7644 21.479H2.56737L1.87437 18.608L11.7084 1.481H18.2424L9.92637 16.067H13.6224L14.1834 12.437L15.8994 9.269H21.0804L20.0244 16.067H22.0044L21.2784 20.489L19.1664 21.479L18.4404 26H12.0384Z" fill="currentColor"/>
      </svg>
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
