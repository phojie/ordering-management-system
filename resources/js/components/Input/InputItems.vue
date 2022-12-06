<script setup lang="ts">
import type { Item } from '@/types/item'
const props = defineProps<{
  modelValue?: Array<Item>
}>()

const emit = defineEmits(['update:modelValue'])

const value = useVModel(props, 'modelValue', emit)

const items = ref<Array<Item>>([])

onMounted(async () => {
  await useFetch(route('components.items')).get().json().then(({ data }) => {
    items.value = data.value
  })
})
</script>

<template>
  <Suspense>
    <JVSelect
      v-model="value"
      label="Items"
      selected-label="name"
      multiple
      :options="items"
      :close-on-select="false"
    />

    <template #fallback>
      Loading...
    </template>
  </Suspense>
</template>
