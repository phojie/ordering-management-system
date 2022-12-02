<script setup lang="ts">
const props = defineProps<{
  modelValue: boolean
}>()

// set emits
const emit = defineEmits(['update:modelValue'])
const value = useVModel(props, 'modelValue', emit)

/*
* how to use this component
* <JSwitch v-model="value" />
*/
</script>

<template>
  <Switch
    v-model="value"
    class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:ml-auto"
    :class="[value ? 'bg-primary-600' : 'bg-gray-200']"
  >
    <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform bg-white rounded-full shadow ring-0" :class="[value ? 'translate-x-5' : 'translate-x-0']" />
  </Switch>
</template>
