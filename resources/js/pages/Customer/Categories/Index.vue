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
  <div class="flex flex-col gap-4 px-4 py-10 mx-auto overflow-hidden max-w-7xl sm:px-6 lg:px-8">
    <div class="flex justify-end">
      <InputSearch
        v-model="search"
        class="w-full lg:max-w-md"
        :processing="processing"
        placeholder="Search by category name"
      />
    </div>

    <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-x-8">
      <JLink
        v-for="category in categories " :key="category.id"
        :to="route('categories.show', {
          slug: category.slug as string,
        })"
        class="text-sm group"
      >
        <div class="w-full overflow-hidden bg-gray-100 rounded-lg aspect-w-1 aspect-h-1 group-hover:opacity-75">
          <img :src="category.image" :alt="category.slug" class="object-cover object-center w-full h-full">
        </div>
        <h3 class="mt-4 font-medium text-gray-900">
          {{ category.name }}
        </h3>
        <p class="italic text-gray-500">
          {{ category.description }}
        </p>
        <p class="mt-2 text-gray-900">
          <span v-if="category.productsCount as number > 0">
            {{ category.productsCount }} {{ category.productsCount as number > 1 ? 'products' : 'product' }}
          </span>
          <span v-else class="font-light text-warning-600">
            No products available yet
          </span>
        </p>
      </JLink>
    </div>
  </div>
</template>
