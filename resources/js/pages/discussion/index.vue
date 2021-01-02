<template>
  <div class="flex flex-row w-full h-full">
    <div
      class="flex flex-col flex-none w-full h-full md:w-72 lg:w-96 xl:w-1/3 bg-toolbar-default text-on-toolbar-default"
      :class="{ 'hidden md:flex': show_discussion }"
    >
      <div class="flex flex-row items-center flex-none px-3 py-4 border-b md:border-r border-on-toolbar-border">
        <h1 class="flex-auto mx-1 text-lg truncate">Blabla Général</h1>
        <paginator class="flex-none mx-1" :paginator="_.omit(discussions, 'data')" :only="['discussions']" />
        <t-button class="flex-none mx-1" @click="reload" variant="secondary"
          ><i class="text-xs fas fa-fw fa-redo"></i
        ></t-button>
      </div>
      <div class="flex-auto h-0 border-b md:border-r border-on-toolbar-border">
        <div
          class="w-full h-full overflow-y-auto scrollbar-thin scrollbar-track-toolbar-default scrollbar-thumb-on-toolbar-border hover:scrollbar-thumb-on-toolbar-border"
          scroll-region
        >
          <button
            v-for="item in discussions.data"
            class="w-full px-4 py-4 text-left border-b outline-none border-on-toolbar-border transition-background hover:bg-toolbar-hover focus:bg-toolbar-active focus:outline-none"
            :key="item.id"
            :class="{
              'bg-toolbar-selected text-on-toolbar-selected focus:bg-toolbar-selected hover:bg-toolbar-selected hover:text-on-toolbar-selected':
                show_discussion && discussion && item.id == discussion.id,
            }"
            @click="
              discussion = undefined;
              $inertia.visit($route('next.discussions.show', [item.id, item.slug]));
            "
          >
            <div class="flex flex-row items-center">
              <div class="flex-none mr-4 w-avatar">
                <img :src="item.user.avatar_link" :alt="item.user.name" class="rounded-avatar" />
              </div>
              <div class="flex-auto truncate">
                <div class="pr-2 truncate">
                  <inertia-link
                    @click.stop="discussion = undefined"
                    :href="$route('next.discussions.show', [item.id, item.slug])"
                    :only="['discussion']"
                    preserve-scroll
                    class="font-semibold"
                  >
                    <i v-if="item.sticky" class="mr-1 text-sm fas fa-fw fa-thumbtack text-green-default"></i>
                    <i v-else-if="item.locked" class="mr-1 text-sm fas fa-fw fa-lock text-orange-default"></i>
                    <i v-else-if="item.replies >= 10" class="mr-1 text-sm fas fa-fw fa-folder text-red-default"></i>
                    <i v-else class="mr-1 text-sm fas fa-fw fa-folder text-yellow-default"></i>

                    {{ item.title }}
                  </inertia-link>
                </div>
                <div class="text-sm truncate">
                  <inertia-link @click.stop="" :href="$route('user.show', item.user.name)">{{
                    item.user.display_name
                  }}</inertia-link>
                  <span class="opacity-50">&bullet;</span>
                  {{ item.replies }} réponse(s)
                </div>
              </div>
              <div class="flex-none ml-4 text-sm">
                <inertia-link :href="$route('posts.show', item.latest_post.id)">
                  {{
                    moment(item.latest_post.created_at)
                      .fromNow()
                      .replace('il y a ', '')
                  }}
                </inertia-link>
              </div>
            </div>
          </button>
        </div>
      </div>
    </div>
    <div class="flex flex-col flex-auto w-0" v-if="show_discussion && discussion">
      <div class="flex flex-col items-center flex-none px-3 py-4 border-b border-on-background-border">
        <div class="flex flex-row items-center w-full mb-4">
          <t-button variant="secondary" @click="blur" class="flex-none mx-1"
            ><i class="text-xs fas fa-fw fa-arrow-left"></i
          ></t-button>
          <h2 class="flex-auto mx-1 text-lg text-center truncate">{{ discussion.title }}</h2>
          <template v-if="$page.props.user">
            <t-button href="#" class="flex-none mx-1"><i class="fas fa-plus"></i></t-button>
            <t-button :href="$route('discussions.unsubscribe', [discussion.id, discussion.slug])" class="flex-none mx-1"
              ><i class="fas fa-fw fa-star"></i
            ></t-button>
          </template>
          <t-button variant="secondary" @click="reload" class="flex-none"
            ><i class="text-xs fas fa-fw fa-redo"></i
          ></t-button>
        </div>

        <paginator :paginator="_.omit(discussion.posts, 'data')" :only="['discussion']" />
      </div>
      <div class="flex-auto h-0">
        <div
          class="w-full h-full overflow-y-auto scrollbar-thin scrollbar-track-background-default scrollbar-thumb-on-background-border hover:scrollbar-thumb-on-background-border"
          scroll-region
        >
          <div v-for="post in discussion.posts.data" :key="post.id" class="m-4 mb-6">
            <div class="flex flex-row w-full">
              <div class="flex-none mr-4 w-avatar-lg">
                <img :src="post.user.avatar_link" :alt="post.user.name" class="rounded-avatar" />
              </div>
              <div class="flex-auto overflow-auto">
                <inertia-link @click.stop="" :href="$route('user.show', post.user.name)">{{
                  post.user.display_name
                }}</inertia-link>
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

                <div
                  class="w-full prose break-words max-w-none"
                  v-if="!post.deleted_at"
                  v-html="md.render(post.presented_body)"
                ></div>
                <div class="w-full" v-else>
                  <i class="mr-2 fas fa-times text-error-default"></i> Ce message a été supprimé
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="flex items-center justify-center flex-auto hidden text-accent-default md:flex" v-else>
      <logo class="w-48 mx-auto opacity-30" />
    </div>
  </div>
</template>

<script>
export default {
  layout: require('../../layouts/app').default,

  props: {
    discussions: Object,
    discussion: Object,
  },

  data() {
    return {
      show_discussion: false,
    };
  },

  mounted() {
    this.show_discussion = this.discussion ? true : false;
  },

  methods: {
    blur() {
      this.show_discussion = false;
    },
    select(discussion) {
      this.selectedDiscussionId = discussion.id;
      this.$inertia.visit(route('discussions.show', [discussion.id, discussion.slug]), {
        preserveScroll: true,
        only: ['discussion'],
      });
    },
    reload() {
      this.$inertia.reload({ preserveScroll: true });
    },
  },
};
</script>
