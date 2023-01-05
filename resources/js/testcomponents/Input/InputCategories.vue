<script setup lang="ts">
import type { Category } from '@/types/category'
const props = defineProps<{
  modelValue?: Array<Category>
}>()

const emit = defineEmits(['update:modelValue'])

const value = useVModel(props, 'modelValue', emit)

const categories = ref<Array<Category>>([])

onMounted(async () => {
  await useFetch(route('components.categories')).get().json().then(({ data }) => {
    categories.value = data.value
  })
})
</script>

<template>
  <Suspense>
    <JVSelect
      v-model="value"
      label="Categories"
      selected-label="name"
      multiple
      :options="categories"
      :close-on-select="false"
    />

    <template #fallback>
      Loading...
    </template>
  </Suspense>
</template>
