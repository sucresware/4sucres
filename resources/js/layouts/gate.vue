<template>
  <div class="flex flex-col items-center justify-center min-h-screen">
    <inertia-link :href="$route('next.home')">
      <img
        src="/img/4sucres_alt_glitched.png"
        alt="4sucres.org"
        class="inline-block h-16 mb-8"
      />
    </inertia-link>
    <slot></slot>
  </div>
</template>

<script>
export default {};
</script>
