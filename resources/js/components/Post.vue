<template>
  <div class="post p-3 row no-gutters" :id="'p' + post.id">
    <div class="col-auto mr-3">
      <a :href="post.user.link">
        <img :src="'/storage/avatars/' + post.user.avatar" class="post-image rounded">
      </a>
    </div>
    <div class="col">
      <template v-if="!post.discussion.private">
        <div class="float-right">
          <a class="mr-1" :href="post.link">
            <i class="fas fa-fw fa-link"></i>
          </a>
          <template v-if="auth_user">
            <!-- <a class="mr-1" href="javascript:void(0)" data-placement="left" data-popover-content="#react_to_post.id" data-toggle="popover" data-trigger="focus"><i class="far fa-fw fa-smile"></i></a> -->
            <template v-if="!post.deleted">
              <a class="mr-1" href="#reply" data-action="quotePost" data-id="post.id">
                <i class="fas fa-fw fa-quote-right"></i>
              </a>
            </template>
            <template
              v-if="(auth_user && post.user.id == auth_user.id && !post.deleted) || auth_user_can('bypass discussions guard')"
            >
              <a
                class="mr-1"
                :href="route('discussions.posts.edit', [post.discussion.id, post.discussion.slug, post.id])"
              >
                <i class="fas fa-fw fa-edit"></i>
              </a>
            </template>
            <template v-if="!post.deleted">
              <a
                class="mr-1 text-danger"
                :href="route('discussions.posts.delete', [post.discussion.id, post.discussion.slug, post.id])"
              >
                <i class="fas fa-fw fa-trash"></i>
              </a>
            </template>
          </template>
        </div>
      </template>

      <a :href="post.user.link">
        <strong>{{ post.user.display_name }}</strong>
      </a>
      <small>@{{ post.user.name }}</small>
      <br>

      <small>
        <a :href="post.link">le {{ post.presented_created_at }}</a>
        <div v-if="post.created_at != post.updated_at">
          <span class="text-muted">(modifié le {{ post.presented_updated_at }})</span>
        </div>
      </small>

      <hr>

      <div class="post-content">
        <div v-if="post.deleted" class="text-danger mb-3">
          <i class="fas fa-times"></i> Message supprimé
        </div>
        <div v-if="!post.deleted || auth_user_can('read deleted posts')">
          <div v-html="post.presented_body"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["post"],
  mounted() {}
};
</script>