<script setup lang="ts">
const props = defineProps<{
  name?: string
}>()
</script>

<template>
  <div>
    {{ props.name }}
  </div>
</template>
