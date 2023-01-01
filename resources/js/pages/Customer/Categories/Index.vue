<script setup lang="ts">
import type { Category } from '@/types/category'

const props = defineProps<{
  categories: Array<Category>
}>()
</script>

<template>
  <div class="bg-white">
    <div class="px-4 py-16 mx-auto overflow-hidden max-w-7xl sm:py-24 sm:px-6 lg:px-8">
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
          <p class="mt-2 font-medium text-gray-900">
            {{ category.productsCount }} {{ category.productsCount as number > 1 ? 'products' : 'product' }}
          </p>
        </JLink>
      </div>
    </div>
  </div>
</template>
