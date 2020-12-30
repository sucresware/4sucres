<template>
  <div class="flex flex-row w-full h-full min-h-0">
    <div class="flex flex-col flex-none w-full md:w-72 lg:w-96 xl:w-1/3" :class="{ 'hidden md:flex': show_discussion }">
      <div class="flex-none p-4 border-b border-r bg-toolbar-default text-on-toolbar-default border-on-background-border">
        <div class="flex flex-row items-center">
          <div class="mr-auto text-lg">Discussions</div>
          <paginator :paginator="_.omit(discussions, 'data')" :only="['discussions']" />
          <t-button @click="reload" class="ml-2"><i class="fas fa-sync"></i></t-button>
        </div>
      </div>
      <div class="flex-auto overflow-y-auto border-r border-on-background-border" scroll-region>
        <div
          v-for="item in discussions.data"
          class="px-4 py-3 duration-150 cursor-pointer transition-background hover:bg-background-hover focus:bg-background-active"
          :key="item.id"
          :class="{ 'bg-background-selected text-on-background-selected hover:bg-background-selected hover:text-on-background-selected': (show_discussion && discussion && item.id == discussion.id) }"
          @click="$inertia.visit($route('next.discussions.show', [item.id, item.slug]))"
        >
          <div class="flex flex-row items-center">
            <div class="flex-none mr-4 w-avatar">
              <img :src="item.user.avatar_link" :alt="item.user.name" class="rounded-avatar">
            </div>
            <div class="flex-auto truncate">
              <div class="pr-2 truncate">
                <inertia-link @click.stop="" :href="$route('next.discussions.show', [item.id, item.slug])" :only="['discussion']" preserve-scroll class="font-bold">
                  {{ item.title }}
                </inertia-link>
              </div>
              <div class="text-sm">
                <inertia-link @click.stop="" :href="$route('user.show', item.user.name)">{{ item.user.display_name }}</inertia-link>
                <span class="opacity-50">&bullet;</span>
                {{ item.replies }} réponse(s)
              </div>
            </div>
            <div class="flex-none">
              <inertia-link :href="$route('posts.show', item.latest_post.id)">
                {{ moment(item.latest_post.created_at).fromNow().replace('il y a ', '') }}
              </inertia-link>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="flex flex-col flex-auto w-full" v-if="show_discussion && discussion">
      <div class="p-4 border-b bg-toolbar-default text-on-toolbar-default border-on-background-border">
        <div class="flex flex-row items-center">
          <t-button @click="blur" class="mr-2"><i class="fas fa-arrow-left"></i></t-button>
          <div class="mr-auto text-lg">{{ discussion.title }}</div>
          <paginator :paginator="_.omit(discussion.posts, 'data')" :only="['discussion']" />
          <template v-if="$page.props.user">
            <t-button href="#" class="ml-2"><i class="fas fa-plus"></i></t-button>
            <t-button :href="$route('discussions.unsubscribe', [discussion.id, discussion.slug])" class="ml-2"><i class="fas fa-star"></i></t-button>
          </template>
          <t-button @click="reload" class="ml-2"><i class="fas fa-sync"></i></t-button>
        </div>
      </div>
      <div class="flex-auto overflow-y-auto bg-background-alt" scroll-region>
        <div
          v-for="post in discussion.posts.data"
          :key="post.id"
          class="m-4"
        >
          <div class="flex flex-row">
            <div class="flex-none mr-4 w-avatar-lg">
              <img :src="post.user.avatar_link" :alt="post.user.name" class="rounded-avatar">
            </div>
            <div class="flex-auto">
              <inertia-link @click.stop="" :href="$route('user.show', post.user.name)">{{ post.user.display_name }}</inertia-link>
              <span class="opacity-50">&bullet;</span>
              <inertia-link :href="post.link" class="text-sm">
                {{ moment(post.created_at).format('L') }} {{ moment(post.created_at).format('LTS') }}
                <span v-if="post.created_at != post.updated_at">
                  (modifié, {{ moment(post.updated_at).calendar() }})
                </span>
              </inertia-link>

              <!-- <div class="ml-auto">
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
              </div> -->

              <div class="prose break-words max-w-none" v-if="!post.deleted_at" v-html="md.render(post.presented_body)"></div>
              <div v-else><i class="mr-1 fal fa-times"></i> Ce message a été supprimé</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="flex items-center justify-center flex-auto hidden w-full overflow-y-auto bg-background-alt text-accent-default md:flex" v-else>
      <svg class="block w-48 mx-auto fill-current opacity-30" viewBox="0 0 36 28" xmlns="http://www.w3.org/2000/svg">
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
