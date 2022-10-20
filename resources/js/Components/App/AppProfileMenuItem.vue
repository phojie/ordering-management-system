<script setup lang="ts">
const props = defineProps<{
  isActive?: boolean
}>()
</script>

<template>
  <Link
    class="block px-4 py-2 text-sm cursor-pointer"
    :class="[props.isActive ? 'bg-gray-100 text-gray-900' : 'text-gray-700']"
  >
    <slot />
  </Link>
</template>
