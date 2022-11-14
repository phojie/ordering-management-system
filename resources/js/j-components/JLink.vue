<script setup lang="ts">
defineProps<{
  to: any
  active?: boolean
  activeClass?: string
}>()
</script>

<template>
  <Link
    :href="to"
    :class="[active ? activeClass : '', { 'cursor-default': !to || to === '#' }]"
  >
    <slot />
  </Link>
</template>
