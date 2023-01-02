<script setup lang="ts">
// import { ShieldCheckIcon, XMarkIcon } from '@heroicons/vue/24/outline'
// import { CheckIcon, QuestionMarkCircleIcon, StarIcon } from '@heroicons/vue/20/solid'

// const product = {
//   name: 'Everyday Ruck Snack',
//   price: '$220',
//   rating: 3.9,
//   href: '#',
//   imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-quick-preview-03-detail.jpg',
//   imageAlt: 'Interior of light green canvas bag with padded laptop sleeve and internal organization pouch.',
//   variants: [
//     { name: '18L', description: 'Perfect for a reasonable amount of snacks.' },
//     { name: '20L', description: 'Enough room for a serious amount of snacks.' },
//   ],
// }

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
  return props.variants.length > 0 ? `₱${props.variants?.map(variant => variant.price).join(' / ₱')}` : 'No price available'
})

const open = ref(true)
const selectedVariant = ref(props.variants[0])
</script>

<template>
  <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="relative z-10" @close="open = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 hidden transition-opacity bg-gray-500 bg-opacity-75 md:block" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-stretch justify-center min-h-full text-center md:items-center md:px-2 lg:px-4">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 md:translate-y-0 md:scale-95" enter-to="opacity-100 translate-y-0 md:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 md:scale-100" leave-to="opacity-0 translate-y-4 md:translate-y-0 md:scale-95">
            <DialogPanel class="flex w-full text-base text-left transition transform md:my-8 md:max-w-2xl md:px-4 lg:max-w-4xl">
              <div class="relative flex items-center w-full px-4 pb-8 overflow-hidden bg-white shadow-2xl pt-14 sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                <button type="button" class="absolute text-gray-400 top-4 right-4 hover:text-gray-500 sm:top-8 sm:right-6 md:top-6 md:right-6 lg:top-8 lg:right-8" @click="open = false">
                  <span class="sr-only">Close</span>
                  <!-- <XMarkIcon class="w-6 h-6" aria-hidden="true" /> -->
                </button>

                <div class="grid items-start w-full grid-cols-1 gap-y-8 gap-x-6 sm:grid-cols-12 lg:gap-x-8">
                  <div class="sm:col-span-4 lg:col-span-5">
                    <div class="overflow-hidden bg-gray-100 rounded-lg aspect-w-1 aspect-h-1">
                      <img :src="image" :alt="slug" class="object-cover object-center">
                    </div>
                    <p class="absolute text-center top-4 left-4 sm:static sm:mt-6">
                      <JLink
                        :to="route('products.show', {
                          slug: slug as string,
                        })" class="font-medium text-indigo-600 hover:text-indigo-500"
                      >
                        View full details
                      </JLink>
                    </p>
                  </div>
                  <div class="sm:col-span-8 lg:col-span-7">
                    <h2 class="text-2xl font-bold text-gray-900 sm:pr-12">
                      {{ name }}
                    </h2>

                    <section aria-labelledby="information-heading" class="mt-4">
                      <h3 id="information-heading" class="sr-only">
                        Product information
                      </h3>

                      <div class="flex items-center">
                        <p class="text-lg text-gray-900 sm:text-xl">
                          <!-- {{ price }} -->
                        </p>

                        <div class="pl-4 ml-4 border-l border-gray-300">
                          <h4 class="sr-only">
                            Reviews
                          </h4>
                          <div class="flex items-center">
                            <div class="flex items-center">
                              <!-- <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" class="flex-shrink-0 w-5 h-5" :class="[product.rating > rating ? 'text-yellow-400' : 'text-gray-300']" aria-hidden="true" /> -->
                            </div>
                            <p class="sr-only">
                              <!-- {{ rating }} out of 5 stars -->
                            </p>
                          </div>
                        </div>
                      </div>

                      <div class="flex items-center mt-6">
                        <heroicons-check-solid class="flex-shrink-0 w-5 h-5 text-green-500" aria-hidden="true" />
                        <p class="ml-2 font-medium text-gray-500">
                          In stock and ready to ship
                        </p>
                      </div>
                    </section>

                    <section aria-labelledby="options-heading" class="mt-6">
                      <h3 id="options-heading" class="sr-only">
                        Product options
                      </h3>

                      <form>
                        <div class="sm:flex sm:justify-between">
                          <!-- Variant selector -->
                          <RadioGroup v-model="selectedVariant">
                            <RadioGroupLabel class="block text-sm font-medium text-gray-700">
                              Variant
                            </RadioGroupLabel>
                            <div class="grid grid-cols-1 gap-4 mt-1 sm:grid-cols-2">
                              <RadioGroupOption v-for="variant in variants" :key="variant.name" v-slot="{ active, checked }" as="template" :value="variant">
                                <div class="relative block p-4 border border-gray-300 rounded-lg cursor-pointer focus:outline-none" :class="[active ? 'ring-2 ring-indigo-500' : '']">
                                  <RadioGroupLabel as="p" class="text-base font-medium text-gray-900">
                                    {{ variant.name }}
                                  </RadioGroupLabel>
                                  <RadioGroupDescription as="p" class="mt-1 text-sm text-gray-500">
                                    <!-- {{ variant.description }} -->
                                  </RadioGroupDescription>
                                  <div class="absolute rounded-lg pointer-events-none -inset-px" :class="[active ? 'border' : 'border-2', checked ? 'border-indigo-500' : 'border-transparent']" aria-hidden="true" />
                                </div>
                              </RadioGroupOption>
                            </div>
                          </RadioGroup>
                        </div>
                        <div class="flex mt-4">
                          <a href="#" class="flex text-sm text-gray-500 group hover:text-gray-700">
                            <span>What variant should I buy?</span>
                            <!-- <QuestionMarkCircleIcon class="flex-shrink-0 w-5 h-5 ml-2 text-gray-400 group-hover:text-gray-500" aria-hidden="true" /> -->
                          </a>
                        </div>
                        <div class="mt-6">
                          <button type="submit" class="flex items-center justify-center w-full px-8 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">
                            Add to bag
                          </button>
                        </div>
                        <div class="mt-6 text-center">
                          <a href="#" class="inline-flex text-base font-medium group">
                            <!-- <ShieldCheckIcon class="flex-shrink-0 w-6 h-6 mr-2 text-gray-400 group-hover:text-gray-500" aria-hidden="true" /> -->
                            <span class="text-gray-500 group-hover:text-gray-700">Lifetime Guarantee</span>
                          </a>
                        </div>
                      </form>
                    </section>
                  </div>
                </div>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
