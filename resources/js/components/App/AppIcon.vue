<script setup lang="ts">
interface AppIconProps {
  dark?: boolean
}

const props = withDefaults(defineProps<AppIconProps>(), {
  dark: false,
})

const logo = computed(() => {
  if (props.dark)
    return '/logo/dark.svg'

  return '/logo/light.svg'
})
</script>

<template>
  <!-- shade 600 -->
  <!-- <img src="https://tailwindui.com/img/logos/mark.svg?color=blue&shade=600" alt="."> -->
  <img :src="logo" alt="." class="rounded-full">
  <!-- </div> -->
</template>
