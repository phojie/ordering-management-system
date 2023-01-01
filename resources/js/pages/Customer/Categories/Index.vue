<script lang="ts" setup>
import type { Category } from '@/types/category'

const props = defineProps<{
  categories: Array<Category>
}>()

// const categories = [
//   {
//     id: 1,
//     name: 'Nomad Pouch',
//     href: '#',
//     price: '$50',
//     availability: 'White and Black',
//     imageSrc: 'https://tailwindui.com/img/ecommerce-images/category-page-07-category-01.jpg',
//     imageAlt: 'White fabric pouch with white zipper, black zipper pull, and black elastic loop.',
//   },
//   {
//     id: 2,
//     name: 'Zip Tote Basket',
//     href: '#',
//     price: '$140',
//     availability: 'Washed Black',
//     imageSrc: 'https://tailwindui.com/img/ecommerce-images/category-page-07-category-02.jpg',
//     imageAlt: 'Front of tote bag with washed black canvas body, black straps, and tan leather handles and accents.',
//   },
//   {
//     id: 3,
//     name: 'Medium Stuff Satchel',
//     href: '#',
//     price: '$220',
//     availability: 'Blue',
//     imageSrc: 'https://tailwindui.com/img/ecommerce-images/category-page-07-category-03.jpg',
//     imageAlt:
//       'Front of satchel with blue canvas body, black straps and handle, drawstring top, and front zipper pouch.',
//   },
// More categories...
// ]
</script>

<template>
  <div class="bg-white">
    <div class="px-4 py-16 mx-auto overflow-hidden max-w-7xl sm:py-24 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-x-8">
        <JLink
          v-for="category in categories" :key="category.id"
          :to="route('categories.show', {
            slug: category.slug,
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
            {{ category.availability }}
          </p>
          <p class="mt-2 font-medium text-gray-900">
            {{ category.price }}
          </p>
        </JLink>
      </div>
    </div>
  </div>
</template>
