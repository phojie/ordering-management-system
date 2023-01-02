<script setup lang="ts">
defineProps<{
  to: any
  active?: boolean
  activeClass?: string
  disabled?: boolean
}>()
</script>

<template>
  <Link
    :href="!disabled ? to : '#'"
    :class="[
      active ? activeClass : '', { 'cursor-default': !to || to === '#' },
      disabled ? 'cursor-not-allowed' : '',
    ]"
  >
    <slot />
  </Link>
</template>
