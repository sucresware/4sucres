<template>
  <label class="block">
    <span v-if="label" class="block mb-2 text-sm font-semibold" v-text="label"></span>

    <div :class="{ error: errors.length }">
      <input ref="file" type="file" :accept="accept" class="hidden" @change="change" />
      <div v-if="!value">
        <t-button class="px-3" @click="browse">
          <i class="mr-2 opacity-50 fas fa-file"></i> Choisir un fichier
        </t-button>
      </div>
      <div v-else class="flex items-center justify-between">
        <div class="flex-none truncate">
          <div class="truncate">
            {{ value.name }}
            <span class="text-on-background-muted">({{ get_readable_file_size_string(value.size) }})</span>
          </div>
        </div>
        <t-button class="px-3" @click.stop="remove">
          Supprimer
        </t-button>
      </div>
    </div>

    <p v-if="errors.length" class="pl-1 text-sm text-red-default" v-text="errors[0]"></p>
  </label>
</template>

<script>
export default {
  inheritAttrs: false,

  props: {
    value: File,
    label: String,
    accept: String,
    errors: {
      type: Array,
      default: () => [],
    },
  },

  watch: {
    value(value) {
      if (!value) {
        this.$refs.file.value = '';
      }
    },
  },

  methods: {
    get_readable_file_size_string(file_size_in_bytes) {
      var i = -1;
      var byte_units = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
      do {
        file_size_in_bytes = file_size_in_bytes / 1024;
        i++;
      } while (file_size_in_bytes > 1024);

      return Math.max(file_size_in_bytes, 0.1).toFixed(1) + byte_units[i];
    },
    browse() {
      this.$refs.file.click();
    },
    change(e) {
      this.$emit('input', e.target.files[0]);
    },
    remove() {
      this.$emit('input', null);
    },
  },
};
</script>
