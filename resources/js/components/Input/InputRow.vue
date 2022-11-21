<script setup lang="ts">
const props = defineProps<{
  modelValue?: any
}>()

const emit = defineEmits(['update:modelValue'])
const value = useVModel(props, 'modelValue', emit)

const items = ['10', '20', '30', '50']

watch(value, (value) => {
  useUserStore().getUsers({ rows: value })
})
</script>

<template>
  <JSelect
    v-model="value"
    :items="items"
  />
</template>
