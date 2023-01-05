<script setup lang="ts">
import type { Variant } from '@/types/variant'
const props = defineProps<{
  name: string
  slug: string
  image: string
  description: string
  variants: Array<Variant>
}>()

const priceRange = $computed(() => {
  const prices = props.variants.map(variant => variant.price)
  const min = Math.min(...prices)
  const max = Math.max(...prices)

  return min === max ? `₱${min}` : `₱${min} - ₱${max}`
})
</script>

<template>
  <div>
    <div class="relative">
      <div class="relative w-full overflow-hidden rounded-lg h-72">
        <img :src="image" :alt="slug" class="object-cover object-center w-full h-full" loading="lazy">
      </div>

      <div class="relative h-16 mt-4">
        <h3 class="text-sm font-medium text-gray-900">
          {{ name }}
        </h3>
        <p
          v-tooltip="`${description} `"
          class="mt-1 text-sm text-gray-500 line-clamp-2"
        >
          {{ description }}
        </p>
      </div>

      <div class="absolute inset-x-0 top-0 flex items-end justify-end p-4 overflow-hidden rounded-lg h-72">
        <div aria-hidden="true" class="absolute inset-x-0 bottom-0 opacity-50 h-36 bg-gradient-to-t from-black" />
        <p v-if="variants.length > 0" class="relative text-lg font-semibold text-white">
          {{ priceRange }}
        </p>
      </div>

      <div class="flex flex-col mt-3">
        <h4 class="text-sm text-gray-700">
          Variants
        </h4>
        <div class="flex h-10 gap-1 mt-1 overflow-auto">
          <div
            v-for="variant in variants"
            :key="variant.id"
          >
            <JBadge
              v-tooltip="`${variant.inStock ? `PHP ${variant.price}` : 'Out of stock'}`"
              class="cursor-pointer group"
              :variant="variant.inStock ? 'text' : 'danger'"
            >
              <span
                :style="`background-color:${variant.color}`"
                :class="{ 'bg-gray-400': !variant.color }"
                class="w-2 h-2 mr-1 rounded-full"
              />
              <span
                class="mr-1 "
              > {{ variant.name }} </span>
            </JBadge>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-6">
      <JLink
        :disabled="variants.length === 0"
        :to="route('products.show', {
          slug: slug as string,
        })"
        class="relative flex items-center justify-center px-8 py-2 text-sm border border-transparent rounded-md"
        :class="variants.length > 0 ? 'text-gray-900 font-medium bg-gray-100 hover:bg-gray-200' : 'text-warning-600'"
      >
        <span v-if="variants.length > 0">
          View Product
        </span>
        <span v-else>
          Not Available
        </span>
      </JLink>
    </div>
  </div>
</template>
