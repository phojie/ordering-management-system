<script setup lang="ts">
import type { Product } from '@/types/product'
import { Variant } from '@/types/variant'

const props = defineProps<{
  products: Array<Product>
}>()

const search = ref<string>(useRoute().defaultSearch)
let processing = $ref<boolean>(false)

watch(search, _.debounce((value: string) => {
  Inertia.get(route('products.index'),
    {
      search: value,
    },
    {
      preserveState: true,
      replace: true,
      onBefore: () => {
        processing = true
      },
      onFinish: () => {
        processing = false
      },
    },
  )
}, 500))
</script>

<template>
  <div class="flex flex-col px-4 py-10 mx-auto space-y-8 overflow-hidden max-w-7xl sm:px-6 lg:px-8">
    <div class="flex justify-end">
      <InputSearch
        v-model="search"
        class="w-full lg:max-w-md"
        :processing="processing"
        placeholder="Search by product name"
      />
    </div>

    <div class="grid grid-cols-2 gap-y-10 gap-x-6 sm:grid-cols-3 lg:grid-cols-4 lg:gap-x-8">
      <AppProductCard
        v-for="product in products"
        :key="product.id"
        :name="product.name"
        :image="product.image as string"
        :description="product.description"
        :variants="product.variants as Array<Variant>"
        :slug="product.slug as string"
      />
    </div>
  </div>
</template>
