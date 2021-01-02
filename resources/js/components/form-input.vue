<template>
  <label class="block">
    <span v-if="label" class="block mb-2 text-sm font-bold text-gray-400" v-text="label"></span>

    <t-input
      :variant="{
        error: errors.length,
      }"
      v-bind="$attrs"
      v-model="model"
      v-on="{ ...$listeners }"
    />

    <p v-if="errors.length" class="pl-1 text-sm text-red-500" v-text="errors[0]"></p>
  </label>
</template>

<script>
export default {
  inheritAttrs: false,

  props: {
    id: String,
    label: String,
    value: String,
    errors: {
      type: Array,
      default: () => [],
    },
  },

  computed: {
    model: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit('input', value);
      },
    },
  },
};
</script>
