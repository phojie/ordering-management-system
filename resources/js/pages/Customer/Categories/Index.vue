<script setup lang="ts">
import type { Category } from '@/types/category'

const props = defineProps<{
  categories: Array<Category>
}>()

const search = ref<string>(useRoute().defaultSearch)
let processing = $ref<boolean>(false)

watch(search, _.debounce((value: string) => {
  Inertia.get(route('categories.index'),
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
          Shop by Category
        </h2>
        <p class="mt-4 text-base text-gray-500">
          Browse our categories to find the perfect food for you. We have a wide range of categories to choose from.
        </p>
      </div>

      <div class="flex justify-end">
        <InputSearch
          v-model="search"
          class="w-full lg:max-w-md"
          :processing="processing"
          placeholder="Search by category name"
        />
      </div>
    </div>

    <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-x-8">
      <AppCategoryCard
        v-for="category in categories" :key="category.id"
        :name="category.name"
        :image="category.image as string"
        :description="category.description"
        :slug="category.slug as string"
        :products-count="category.productsCount as number"
      />
    </div>
  </div>
</template>
