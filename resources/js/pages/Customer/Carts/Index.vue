<script setup lang="ts">
import type { Cart } from '@/types/cart'

const props = defineProps<{
  carts: Array<Cart>
}>()

// const carts = [
//   {
//     id: 1,
//     name: 'Basic Tee',
//     href: '#',
//     price: '₱32.00',
//     color: 'Sienna',
//     inStock: true,
//     variant: 'Large',
//     imageSrc: 'https://tailwindui.com/img/ecommerce-images/shopping-cart-page-01-cart-01.jpg',
//     imageAlt: 'Front of men\'s Basic Tee in sienna.',
//   },
//   {
//     id: 2,
//     name: 'Basic Tee',
//     href: '#',
//     price: '₱32.00',
//     color: 'Black',
//     inStock: false,
//     leadTime: '3–4 weeks',
//     variant: 'Large',
//     imageSrc: 'https://tailwindui.com/img/ecommerce-images/shopping-cart-page-01-cart-02.jpg',
//     imageAlt: 'Front of men\'s Basic Tee in black.',
//   },
//   {
//     id: 3,
//     name: 'Nomad Tumbler',
//     href: '#',
//     price: '₱35.00',
//     color: 'White',
//     inStock: true,
//     imageSrc: 'https://tailwindui.com/img/ecommerce-images/shopping-cart-page-01-cart-03.jpg',
//     imageAlt: 'Insulated bottle with white base and black snap lid.',
//   },
// ]
</script>

<template>
  <div class="max-w-2xl px-4 pt-16 pb-24 mx-auto sm:px-6 lg:max-w-7xl lg:px-8">
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
      Shopping Cart
    </h1>
    <form class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
      <section aria-labelledby="cart-heading" class="lg:col-span-7">
        <h2 id="cart-heading" class="sr-only">
          Items in your shopping cart
        </h2>

        <ul role="list" class="border-t border-b border-gray-200 divide-y divide-gray-200">
          <li v-for="(cart, cartIdx) in carts" :key="cart.id" class="flex py-6 sm:py-10">
            <div class="flex-shrink-0">
              <img :src="cart.product.image" :alt="cart.product.slug" class="object-cover object-center w-24 h-24 rounded-md sm:h-48 sm:w-48">
            </div>

            <div class="flex flex-col justify-between flex-1 ml-4 sm:ml-6">
              <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                <div>
                  <div class="flex justify-between">
                    <h3 class="text-sm">
                      <a :href="cart.product.slug" class="font-medium text-gray-700 hover:text-gray-800">{{ cart.product.name }}</a>
                    </h3>
                  </div>
                  <div class="flex mt-1 text-sm">
                    <p class="text-gray-500">
                      <!-- {{ cart.color }} -->
                    </p>
                    <p v-if="cart.variant" class="pl-4 ml-4 text-gray-500 border-l border-gray-200">
                      <!-- {{ cart.variant }} -->
                    </p>
                  </div>
                  <p class="mt-1 text-sm font-medium text-gray-900">
                    <!-- {{ cart.price }} -->
                  </p>
                </div>

                <div class="mt-4 sm:mt-0 sm:pr-9">
                  <label :for="`quantity-${cartIdx}`" class="sr-only">Quantity, {{ cart.variant.name }}</label>
                  <select :id="`quantity-${cartIdx}`" :value="cart.quantity" name="quantity-${cartIdx}" class="max-w-full rounded-md border border-gray-300 py-1.5 text-left text-base font-medium leading-5 text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                    <option value="1">
                      1
                    </option>
                    <option value="2">
                      2
                    </option>
                    <option value="3">
                      3
                    </option>
                    <option value="4">
                      4
                    </option>
                    <option value="5">
                      5
                    </option>
                    <option value="6">
                      6
                    </option>
                    <option value="7">
                      7
                    </option>
                    <option value="8">
                      8
                    </option>
                  </select>

                  <div class="absolute top-0 right-0">
                    <button type="button" class="inline-flex p-2 -m-2 text-gray-400 hover:text-gray-500">
                      <span class="sr-only">Remove</span>
                      <heroicons-x-mark-20-solid class="w-5 h-5" aria-hidden="true" />
                    </button>
                  </div>
                </div>
              </div>

              <p class="flex mt-4 space-x-2 text-sm text-gray-700">
                <heroicons-check-20-solid v-if="cart.variant?.inStock" class="flex-shrink-0 w-5 h-5 text-green-500" aria-hidden="true" />
                <heroicons-clock-20-solid v-else class="flex-shrink-0 w-5 h-5 text-gray-300" aria-hidden="true" />
                <span>{{ cart.variant?.inStock ? 'In stock' : `Ships in 30 minutes` }}</span>
              </p>
            </div>
          </li>
        </ul>
      </section>

      <!-- Order summary -->
      <section aria-labelledby="summary-heading" class="px-4 py-6 mt-16 rounded-lg bg-gray-50 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8">
        <h2 id="summary-heading" class="text-lg font-medium text-gray-900">
          Order summary
        </h2>

        <dl class="mt-6 space-y-4">
          <div class="flex items-center justify-between">
            <dt class="text-sm text-gray-600">
              Subtotal
            </dt>
            <dd class="text-sm font-medium text-gray-900">
              ₱99.00
            </dd>
          </div>
          <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <dt class="flex items-center text-sm text-gray-600">
              <span>Shipping estimate</span>
              <a href="#" class="flex-shrink-0 ml-2 text-gray-400 hover:text-gray-500">
                <span class="sr-only">Learn more about how shipping is calculated</span>
                <heroicons-question-mark-circle-20-solid class="w-5 h-5" aria-hidden="true" />
              </a>
            </dt>
            <dd class="text-sm font-medium text-gray-900">
              ₱5.00
            </dd>
          </div>
          <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <dt class="flex text-sm text-gray-600">
              <span>Tax estimate</span>
              <a href="#" class="flex-shrink-0 ml-2 text-gray-400 hover:text-gray-500">
                <span class="sr-only">Learn more about how tax is calculated</span>
                <heroicons-question-mark-circle-20-solid class="w-5 h-5" aria-hidden="true" />
              </a>
            </dt>
            <dd class="text-sm font-medium text-gray-900">
              ₱8.32
            </dd>
          </div>
          <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <dt class="text-base font-medium text-gray-900">
              Order total
            </dt>
            <dd class="text-base font-medium text-gray-900">
              ₱112.32
            </dd>
          </div>
        </dl>

        <div class="mt-6">
          <button type="submit" class="w-full px-4 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">
            Checkout
          </button>
        </div>
      </section>
    </form>
  </div>
</template>
