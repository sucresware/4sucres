<template>
  <div v-if="$page.props.flash">
    <div v-for="(message, variant) in $page.props.flash" v-bind:key="variant">
      <t-alert v-if="message" :variant="variant" show>
        {{ message }}
      </t-alert>
    </div>
  </div>
</template>
