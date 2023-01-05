<script setup lang="ts">
import type { Category } from '@/types/category'
import { Product } from '@/types/product'
import { Variant } from '@/types/variant'

const props = defineProps<{
  category: Category
}>()

const search = ref<string>(useRoute().defaultSearch)
let processing = $ref<boolean>(false)

watch(search, _.debounce((value: string) => {
  Inertia.get(route('categories.show', props.category.slug),
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
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
      <div>
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">
          Shop our {{ category.name }}
        </h2>
        <p class="mt-4 text-base text-gray-500">
          {{ category.description }}
        </p>
      </div>

      <div class="flex justify-end">
        <InputSearch
          v-model="search"
          class="w-full lg:max-w-md"
          :processing="processing"
          placeholder="Search by product name"
        />
      </div>
    </div>

    <div class="grid grid-cols-2 gap-y-10 gap-x-6 sm:grid-cols-3 lg:grid-cols-4 lg:gap-x-8">
      <AppProductCard
        v-for="product in category.products as Array<Product>"
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
