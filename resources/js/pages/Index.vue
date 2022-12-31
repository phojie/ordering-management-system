<script setup lang="ts">
import type { Category } from '@/types/categories'
import type { Product } from '@/types/products'

const props = defineProps<{
  categories: Array<Category>
  products: Array<Product>
}>()

const perks = [
  {
    name: 'Free Shipping',
    description: 'It\'s not actually free we just price it into the products. Someone\'s paying for it, and it\'s not us.',
    imageSrc: 'https://tailwindui.com/img/ecommerce/icons/icon-delivery-light.svg',
  },
  {
    name: '24/7 Customer Support',
    description: 'Our AI chat widget is powered by a naive series of if/else statements. Guaranteed to irritate.',
    imageSrc: 'https://tailwindui.com/img/ecommerce/icons/icon-chat-light.svg',
  },
  {
    name: 'Fast Shopping Cart',
    description: 'Look how fast that cart is going. What does this mean for the actual experience? I don\'t know.',
    imageSrc: 'https://tailwindui.com/img/ecommerce/icons/icon-fast-checkout-light.svg',
  },
  {
    name: 'Gift Cards',
    description: 'Buy them for your friends, especially if they don\'t like our store. Free money for us, it\'s great.',
    imageSrc: 'https://tailwindui.com/img/ecommerce/icons/icon-gift-card-light.svg',
  },
]

const productVariantNames = (product: Product) => {
  return product.variants?.map(variant => variant.name).join(', ')
}

const productVariantPrices = (product: Product) => {
  return `₱${product.variants?.map(variant => variant.price).join(' / ₱')}`
}
</script>

<template>
  <main>
    <!-- Hero section -->
    <div class="relative">
      <!-- Background image and overlap -->
      <div aria-hidden="true" class="absolute inset-0 hidden sm:flex sm:flex-col">
        <div class="relative flex-1 w-full bg-gray-800">
          <div class="absolute inset-0 overflow-hidden">
            <img src="/images/cover-photo.jpg" alt="" class="object-cover object-center w-full h-full">
          </div>
          <div class="absolute inset-0 bg-gray-900 opacity-50" />
        </div>
        <div class="w-full h-32 bg-white md:h-40 lg:h-48" />
      </div>

      <div class="relative max-w-3xl px-4 mx-auto text-center pb-96 sm:px-6 sm:pb-0 lg:px-8">
        <!-- Background image and overlap -->
        <div aria-hidden="true" class="absolute inset-0 flex flex-col sm:hidden">
          <div class="relative flex-1 w-full bg-gray-800">
            <div class="absolute inset-0 overflow-hidden">
              <img src="https://tailwindui.com/img/ecommerce-images/home-page-04-hero-full-width.jpg" alt="" class="object-cover object-center w-full h-full">
            </div>
            <div class="absolute inset-0 bg-gray-900 opacity-50" />
          </div>
          <div class="w-full h-48 bg-white" />
        </div>
        <div class="relative py-32">
          <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl">
            Biggest Sale of the Year
          </h1>
          <div class="mt-4 sm:mt-6">
            <a href="#" class="inline-block px-8 py-3 font-medium text-white border border-transparent rounded-md bg-primary-600 hover:bg-primary-700">Shop Category</a>
          </div>
        </div>
      </div>

      <section aria-labelledby="category-heading" class="relative -mt-96 sm:mt-0">
        <h2 id="category-heading" class="sr-only">
          Categories
        </h2>
        <div class="grid max-w-md grid-cols-1 px-4 mx-auto gap-y-6 sm:max-w-7xl sm:grid-cols-3 sm:gap-y-0 sm:gap-x-6 sm:px-6 lg:gap-x-8 lg:px-8">
          <div v-for="category in categories" :key="category.name" class="relative bg-white rounded-lg shadow-xl cursor-pointer group h-96 sm:aspect-w-4 sm:aspect-h-5 sm:h-auto">
            <div>
              <div aria-hidden="true" class="absolute inset-0 overflow-hidden rounded-lg">
                <div class="absolute inset-0 overflow-hidden group-hover:opacity-75">
                  <img :src="category.image" :alt="category.name" class="object-cover object-center w-full h-full">
                </div>
                <div class="absolute inset-0 opacity-50 bg-gradient-to-b from-transparent to-black" />
              </div>
              <div class="absolute inset-0 flex items-end p-6 rounded-lg">
                <div>
                  <p aria-hidden="true" class="text-sm text-white">
                    Shop the category
                  </p>
                  <h3 class="mt-1 font-semibold text-white">
                    <a :href="category.href">
                      <span class="absolute inset-0" />
                      {{ category.name }}
                    </a>
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <section aria-labelledby="trending-heading">
      <div class="px-4 py-24 mx-auto max-w-7xl sm:px-6 sm:py-32 lg:px-8 lg:pt-32">
        <div class="md:flex md:items-center md:justify-between">
          <h2 id="favorites-heading" class="text-2xl font-bold tracking-tight text-gray-900">
            Our Favorites
          </h2>
          <a href="#" class="hidden text-sm font-medium text-primary-600 hover:text-primary-500 md:block">
            Shop the category
            <span aria-hidden="true"> &rarr;</span>
          </a>
        </div>

        <div class="grid grid-cols-2 mt-6 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
          <div v-for="product in products" :key="product.id" class="relative group">
            <div class="w-full h-56 overflow-hidden rounded-md group-hover:opacity-75 lg:h-72 xl:h-80">
              <img :src="product.image" :alt="product.name" class="object-cover object-center w-full h-full">
            </div>
            <h3 class="mt-4 text-sm text-gray-700">
              <a :href="product.slug">
                <span class="absolute inset-0" />
                {{ product.name }}
              </a>
            </h3>
            <p class="mt-1 text-sm text-gray-500">
              {{ productVariantNames(product) }}
            </p>
            <p class="mt-1 text-sm font-medium text-gray-900">
              {{ productVariantPrices(product) }}
            </p>
          </div>
        </div>

        <div class="mt-8 text-sm md:hidden">
          <a href="#" class="font-medium text-primary-600 hover:text-primary-500">
            Shop the category
            <span aria-hidden="true"> &rarr;</span>
          </a>
        </div>
      </div>
    </section>

    <section aria-labelledby="perks-heading" class="border-t border-gray-200 bg-gray-50">
      <h2 id="perks-heading" class="sr-only">
        Our perks
      </h2>

      <div class="px-4 py-24 mx-auto max-w-7xl sm:px-6 sm:py-32 lg:px-8">
        <div class="grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 lg:gap-x-8 lg:gap-y-0">
          <div v-for="perk in perks" :key="perk.name" class="text-center md:flex md:items-start md:text-left lg:block lg:text-center">
            <div class="md:flex-shrink-0">
              <div class="flow-root">
                <img class="w-auto h-24 mx-auto -my-1" :src="perk.imageSrc" alt="">
              </div>
            </div>
            <div class="mt-6 md:mt-0 md:ml-4 lg:mt-6 lg:ml-0">
              <h3 class="text-base font-medium text-gray-900">
                {{ perk.name }}
              </h3>
              <p class="mt-3 text-sm text-gray-500">
                {{ perk.description }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>