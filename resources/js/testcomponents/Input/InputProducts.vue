<script setup lang="ts">
import type { Product } from '@/types/product'
const props = defineProps<{
  modelValue?: Array<Product>
}>()

const emit = defineEmits(['update:modelValue'])

const value = useVModel(props, 'modelValue', emit)

const products = ref<Array<Product>>([])

onMounted(async () => {
  await useFetch(route('components.products')).get().json().then(({ data }) => {
    products.value = data.value
  })
})
</script>

<template>
  <Suspense>
    <JVSelect
      v-model="value"
      label="Products"
      selected-label="name"
      multiple
      :options="products"
      :close-on-select="false"
    />

    <template #fallback>
      Loading...
    </template>
  </Suspense>
</template>
