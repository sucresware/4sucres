<template>
  <div class="editor">
    <div class="editor-buttons btn-toolbar">
      <button type="button" class="btn btn-sm btn-light" @click="bbWrapWith('b')">
        <i class="fas fa-fw fa-bold"></i>
      </button>
      <button type="button" class="btn btn-sm btn-light" @click="bbWrapWith('i')">
        <i class="fas fa-fw fa-italic"></i>
      </button>
      <button type="button" class="btn btn-sm btn-light" @click="bbWrapWith('u')">
        <i class="fas fa-fw fa-underline"></i>
      </button>
      <button type="button" class="btn btn-sm btn-light" @click="bbWrapWith('s')">
        <i class="fas fa-fw fa-strikethrough"></i>
      </button>
      <button type="button" class="btn btn-sm btn-light" @click="insertLink()">
        <i class="fas fa-fw fa-link"></i>
      </button>
      <button type="button" class="btn btn-sm btn-light" @click="bbWrapWith('spoiler')">
        <i class="fas fa-fw fa-eye-slash"></i>
      </button>
      <button type="button" class="btn btn-sm btn-light" @click="bbWrapWith('mock')">mDr</button>
      <button type="button" class="btn btn-sm btn-light" @click="bbWrapWith('glitch')">░█</button>
      <button type="button" class="btn btn-sm btn-light" @click="bbWrapWith('vapor')">ｖａｐｏｒ</button>
      <risibank-picker ref="risibank-picker"></risibank-picker>
    </div>

    <editable-textarea ref="editor">
      <textarea
        name="body"
        v-model="body"
        id="body"
        class="form-control editor-textarea"
        style="height: 200px;"
      ></textarea>
    </editable-textarea>
  </div>
</template>

<script>
import EditableTextarea from "./EditableTextarea.js";

export default {
  components: { EditableTextarea },
  props: ["value"],
  data() {
    return {
      body: ""
    };
  },
  methods: {
    bbWrapWith(pattern) {
      return this.$refs.editor.bbWrapWith(pattern);
    },
    insertLink() {
      let url = prompt("Lien URL");
      if (url) return this.$refs.editor.insert(url);
    },
    insertText(text) {
      return this.$refs.editor.insert(text);
    }
  },
  mounted: function() {
    this.body = this.value;
  }
};
</script>