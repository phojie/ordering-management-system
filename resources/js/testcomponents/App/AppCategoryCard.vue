<script setup lang="ts">
const props = defineProps<{
  name: string
  slug: string
  image: string
  description: string
  productsCount: number
}>()
</script>

<template>
  <JLink
    :to="route('categories.show', {
      slug: slug as string,
    })"
    class="block group"
  >
    <div aria-hidden="true" class="overflow-hidden rounded-lg aspect-w-3 aspect-h-2 group-hover:opacity-75 lg:aspect-w-5 lg:aspect-h-6">
      <img :src="image" :alt="slug" class="object-cover object-center w-full h-full" loading="lazy">
    </div>
    <h3 class="mt-4 text-base font-semibold text-gray-900">
      {{ name }}
    </h3>
    <p class="mt-1 text-sm italic text-gray-500">
      <span v-if="productsCount > 0">
        {{ productsCount }} {{ productsCount > 1 ? 'products' : 'product' }} available
      </span>

      <span v-else class="text-warning-500">
        No products available yet
      </span>
    </p>
    <p class="mt-2 text-sm text-gray-500">
      {{ description }}
    </p>
  </JLink>
</template>
