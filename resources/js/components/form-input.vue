<template>
  <label class="block">
    <span
      v-if="label"
      class="block mb-2 text-sm font-bold text-gray-400"
      v-text="label"
    ></span>

    <input
      class="w-full px-3 py-3 text-sm leading-tight text-gray-200 bg-gray-800 border border-gray-700 rounded appearance-none focus:outline-none focus:shadow-outline"
      :class="{ 'border-red-500 mb-1': errors.length }"
      v-bind="$attrs"
      v-on="{
        ...$listeners,
        input: (event) => $emit('input', event.target.value),
      }"
    />

    <p
      v-if="errors.length"
      class="pl-1 text-sm italic text-red-500"
      v-text="errors[0]"
    ></p>
  </label>
</template>

<script>
export default {
  inheritAttrs: false,

  props: {
    id: String,
    label: String,
    errors: {
      type: Array,
      default: () => [],
    },
  },
};
</script>