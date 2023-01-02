<script setup lang="ts">
const props = defineProps<{
  name: string
  slug: string
  image: string
  variants: {
    name: string
    price: number
  }[]
}>()

const productVariantNames = $computed(() => {
  return props.variants?.map(variant => variant.name).join(' / ')
})

const productVariantPrices = $computed(() => {
  return `₱${props.variants?.map(variant => variant.price).join(' / ₱')}`
})
</script>

<template>
  <div class="relative group">
    <div class="w-full h-56 overflow-hidden rounded-md group-hover:opacity-75 lg:h-72 xl:h-80">
      <img :src="image" :alt="name" class="object-cover object-center w-full h-full">
    </div>
    <h3 class="mt-4 text-sm text-gray-700">
      <JLink
        :to="route('products.show', {
          slug: slug as string,
        })"
      >
        <span class="absolute inset-0" />
        {{ name }}
      </JLink>
    </h3>
    <p class="mt-1 text-sm text-gray-500">
      {{ productVariantPrices }}
    </p>
    <p class="mt-1 text-sm font-medium text-gray-900">
      {{ productVariantNames }}
    </p>
  </div>
</template>
