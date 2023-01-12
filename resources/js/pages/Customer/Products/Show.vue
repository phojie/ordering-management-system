<script setup lang="ts">
import type { Product } from '@/types/product'

const props = defineProps<{
  product: Product
}>()

// const reviews = { average: 4, totalCount: 1624 }

const selectedVariant = $ref(props.product.variants?.[0])

const addToCart = async () => {
  await Inertia.post(route('customer.carts.store'), {
    variantId: selectedVariant?.id as string,
    quantity: 1,
  })
}
</script>

<template>
  <div class="bg-white">
    <div class="max-w-2xl px-4 py-16 mx-auto sm:py-24 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
      <!-- Product details -->
      <div class="lg:max-w-lg lg:self-end">
        <nav aria-label="Breadcrumb">
          <ol role="list" class="flex items-center space-x-2">
            <li v-for="(breadcrumb, breadcrumbIdx) in useRoute().breadCrumb" :key="breadcrumbIdx">
              <div class="flex items-center text-sm">
                <JLink :to="breadcrumb.href" class="font-medium text-gray-500 capitalize hover:text-gray-900">
                  {{ breadcrumb.name }}
                </JLink>
                <svg v-if="breadcrumb.name !== product.slug " viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="currentColor" aria-hidden="true" class="flex-shrink-0 w-5 h-5 ml-2 text-gray-300">
                  <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                </svg>
              </div>
            </li>
          </ol>
        </nav>

        <div class="mt-4">
          <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            {{ product.name }}
          </h1>
        </div>

        <section aria-labelledby="information-heading" class="mt-4">
          <h2 id="information-heading" class="sr-only">
            Product information
          </h2>

          <div class="flex items-center">
            <p class="text-lg text-gray-900 sm:text-xl">
              ₱{{ selectedVariant?.price?.toLocaleString("en-US") }}
            </p>

            <!-- <div class="pl-4 ml-4 border-l border-gray-300">
              <h2 class="sr-only">
                Reviews
              </h2>
              <div class="flex items-center">
                <div>
                  <div class="flex items-center">
                    <heroicons-star-20-solid v-for="rating in [0, 1, 2, 3, 4]" :key="rating" class="flex-shrink-0 w-5 h-5" :class="[reviews.average > rating ? 'text-yellow-400' : 'text-gray-300']" aria-hidden="true" />
                  </div>
                  <p class="sr-only">
                    {{ reviews.average }} out of 5 stars
                  </p>
                </div>
                <p class="ml-2 text-sm text-gray-500">
                  {{ reviews.totalCount }} reviews
                </p>
              </div>
            </div> -->
          </div>

          <div class="mt-4 space-y-6">
            <p class="text-base text-gray-500">
              {{ product.description }}
            </p>
          </div>

          <div v-if="selectedVariant?.inStock" class="flex items-center mt-6">
            <heroicons-check-20-solid class="flex-shrink-0 w-5 h-5 text-green-500" aria-hidden="true" />
            <p class="ml-2 text-sm text-gray-500">
              {{ selectedVariant?.stock }} stock available for immediate delivery
            </p>
          </div>

          <div v-else class="flex items-center mt-6">
            <heroicons-x-mark-20-solid class="flex-shrink-0 w-5 h-5 text-danger-500" aria-hidden="true" />
            <p class="ml-2 text-sm text-gray-500">
              Out of stock
            </p>
          </div>
        </section>
      </div>

      <!-- Product image -->
      <div class="mt-10 lg:col-start-2 lg:row-span-2 lg:mt-0 lg:self-center">
        <div class="overflow-hidden rounded-lg aspect-w-1 aspect-h-1">
          <img :src="product.image" :alt="product.slug" class="object-cover object-center w-full h-full">
        </div>
      </div>

      <!-- Product form -->
      <div class="mt-10 lg:col-start-1 lg:row-start-2 lg:max-w-lg lg:self-start">
        <section aria-labelledby="options-heading">
          <h2 id="options-heading" class="sr-only">
            Product options
          </h2>

          <form>
            <div class="sm:flex sm:justify-between">
              <!-- Variant picker -->
              <div class="w-full mt-8 ">
                <div class="flex items-center justify-between">
                  <h2 class="text-sm font-medium text-gray-900">
                    Variant
                  </h2>
                  <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-500">
                    Learn more
                  </a>
                </div>

                <RadioGroup v-model="selectedVariant" class="mt-2">
                  <RadioGroupLabel class="sr-only">
                    Choose a variant
                  </RadioGroupLabel>
                  <div class="grid grid-cols-3 gap-3 sm:grid-cols-3">
                    <RadioGroupOption v-for="variant in product.variants" :key="variant.name" v-slot="{ active, checked }" as="template" :value="variant" :disabled="!variant.inStock">
                      <div class="flex items-center justify-center px-3 py-3 text-sm font-medium uppercase border rounded-md sm:flex-1" :class="[variant.inStock ? 'cursor-pointer focus:outline-none' : 'opacity-25 cursor-not-allowed', active ? 'ring-2 ring-offset-2 ring-primary-500' : '', checked ? 'bg-primary-600 border-transparent text-white hover:bg-primary-700' : 'bg-white border-gray-200 text-gray-900 hover:bg-gray-50']">
                        <RadioGroupLabel as="p" class="line-clamp-3">
                          {{ variant.name }}
                        </RadioGroupLabel>
                      </div>
                    </RadioGroupOption>
                  </div>
                </RadioGroup>
              </div>
            </div>
            <div class="mt-4">
              <a href="#" class="inline-flex text-sm text-gray-500 group hover:text-gray-700">
                <span>What variant should I buy?</span>
                <heroicons-question-mark-circle-20-solid class="flex-shrink-0 w-5 h-5 ml-2 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
              </a>
            </div>
            <div class="mt-10">
              <JBtn size="lg" is-expanded @click="addToCart()">
                Add to cart
              </JBtn>
            </div>
            <div class="mt-6 text-center">
              <a href="#" class="inline-flex text-base font-medium group">
                <heroicons-shield-check class="flex-shrink-0 w-6 h-6 mr-2 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                <span class="text-gray-500 hover:text-gray-700">
                  On time delivery guarantee
                </span>
              </a>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>
</template>
