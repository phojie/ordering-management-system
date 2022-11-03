<script setup lang="ts">
defineProps<{
  to: string
  active?: boolean
  activeClass?: string
}>()
</script>

<template>
  <Link
    :href="to"
    :class="[active ? activeClass : '', { 'cursor-not-allowed': !to || to === '#' }]"
  >
    <slot />
  </Link>
</template>
