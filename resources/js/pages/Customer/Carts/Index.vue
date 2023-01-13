<script setup lang="ts">
import { Variant } from '@/types/variant'
import type { Cart } from '@/types/cart'
import type { Product } from '@/types/product'

const props = defineProps<{
  carts: Array<Cart>
  relatedProducts: Array<Product>
}>()

const { deleteCart, updateCart } = useCartStore()

const updateCartDebounce = _.debounce((id: string, quantity: number) => {
  updateCart(id, quantity)
}, 500)

// order-summary
const subTotal: number = $computed(() => {
  // filter only the variant that is inStock
  const validCarts = _.filter(props.carts, (cart) => {
    return cart.variant.inStock as boolean
  })

  // calculate the total price
  return validCarts.reduce((total, cart) => {
    return total + (cart.variant.price * cart.quantity)
  }, 0)
})

const shipping: number = $computed(() => {
  return 45
})

const orderTotal: number = $computed(() => {
  return shipping + subTotal
})
</script>

<template>
  <div class="max-w-2xl px-4 pt-16 pb-24 mx-auto sm:px-6 lg:max-w-7xl lg:px-8">
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
      Shopping Cart
    </h1>
    <form v-if="carts.length > 0" class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
      <section aria-labelledby="cart-heading" class="lg:col-span-7">
        <h2 id="cart-heading" class="sr-only">
          Items in your shopping cart
        </h2>

        <ul role="list" class="border-t border-b border-gray-200 divide-y divide-gray-200">
          <li v-for="cart in carts" :key="cart.id" class="flex py-6 sm:py-10">
            <div class="flex-shrink-0">
              <img :src="cart.product.image" :alt="cart.product.slug" class="object-cover object-center w-24 h-24 rounded-md sm:h-48 sm:w-48">
            </div>

            <div class="flex flex-col justify-between flex-1 ml-4 sm:ml-6">
              <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                <div>
                  <div class="flex justify-between">
                    <h3 class="text-sm">
                      <a
                        :href="route('products.show', {
                          slug: cart.product.slug as string,
                        })"
                        target="_blank"
                        class="font-medium text-gray-700 hover:text-gray-800"
                      >{{ cart.product.name }}</a>
                    </h3>
                  </div>
                  <div class="flex mt-1 text-sm">
                    <p class="text-gray-500 line-clamp-1">
                      {{ cart.variant.name }}
                    </p>
                  </div>
                  <p class="mt-1 text-sm font-medium text-gray-900">
                    ₱{{ cart.variant.price.toFixed(2) }}
                  </p>
                </div>

                <div class="mt-4 sm:mt-0 sm:pr-9">
                  <div
                    v-if="cart.variant.inStock"
                    class="w-24"
                  >
                    <JTextField
                      :id="cart.id"
                      v-model="cart.quantity"
                      :is-disabled="!cart.variant.inStock"
                      :name="cart.id"
                      type="number"
                      hints="Qty."
                      :error-message="`${cart.variant.stock} is the maximum quantity available.`"
                      :is-error="cart.quantity > cart.variant.stock"
                      @input="updateCartDebounce(cart.id, cart.quantity)"
                    />
                  </div>

                  <div class="absolute top-0 right-0">
                    <button type="button" class="inline-flex p-2 -m-2 text-gray-400 hover:text-gray-500" @click="deleteCart(cart.id)">
                      <span class="sr-only">Remove</span>
                      <heroicons-x-mark-20-solid class="w-5 h-5" aria-hidden="true" />
                    </button>
                  </div>
                </div>
              </div>

              <div class="flex justify-between mt-4 text-sm">
                <p class="flex space-x-2 text-gray-700">
                  <heroicons-check-20-solid v-if="cart.variant?.inStock" class="flex-shrink-0 w-5 h-5 text-green-500" aria-hidden="true" />
                  <heroicons-clock-20-solid v-else :class="cart.variant?.inStock ? '' : 'text-warning-500'" class="flex-shrink-0 w-5 h-5 text-gray-300" aria-hidden="true" />
                  <span>{{ cart.variant?.inStock ? `${cart.variant.stock} stock available` : `Out of stock` }}</span>
                </p>

                <p v-if="cart.variant.inStock">
                  Total: <span class="font-medium">₱{{ (cart.variant.price * cart.quantity).toFixed(2) }}</span>
                </p>
              </div>
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
              ₱{{ subTotal.toFixed(2) }}
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
              ₱{{ shipping.toFixed(2) }}
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
              ₱0.00
            </dd>
          </div>
          <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <dt class="text-base font-medium text-gray-900">
              Order total
            </dt>
            <dd class="text-base font-medium text-gray-900">
              ₱{{ orderTotal.toFixed(2) }}
            </dd>
          </div>
        </dl>

        <div class="mt-6">
          <JLink
            :to="route('customer.carts.checkout')"
          >
            <JBtn
              size="lg"
              is-expanded
              label="Checkout"
            />
          </JLink>
        </div>

        <div class="mt-6 text-sm text-center">
          <p>
            or
            <JLink :to="route('products.index')" class="font-medium text-primary-600 hover:text-primary-500">
              Continue Shopping
              <span aria-hidden="true"> &rarr;</span>
            </JLink>
          </p>
        </div>
      </section>
    </form>

    <div v-else class="w-full mt-12">
      <div class="grid place-items-center">
        <img src="/svgs/empty_cart.svg" class="w-80 h-80">

        <div class="mt-10 text-lg font-medium text-gray-900">
          Your cart is empty.
          <JLink :to="route('products.index')" class="text-sm font-medium text-primary-600 hover:text-primary-500">
            Shop here
            <span aria-hidden="true"> &rarr;</span>
          </JLink>
        </div>
      </div>
    </div>

    <!-- Related products -->
    <section aria-labelledby="related-heading" class="mt-24">
      <h2 id="related-heading" class="text-lg font-medium text-gray-900">
        You may also like&hellip;
      </h2>

      <div class="grid grid-cols-1 mt-6 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
        <AppProductCard
          v-for="product in relatedProducts" :key="product.id"
          :name="product.name"
          :image="product.image as string"
          :description="product.description"
          :variants="product.variants as Array<Variant>"
          :slug="product.slug as string"
          :product="product"
        />
      </div>
    </section>
  </div>
</template>
