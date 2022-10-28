<script setup lang="ts">
defineProps<{
  href: string
  active?: boolean
  activeClass?: string
}>()
</script>

<template>
  <Link :href="href" :class="active ? activeClass : ''">
    <slot />
  </Link>
</template>
