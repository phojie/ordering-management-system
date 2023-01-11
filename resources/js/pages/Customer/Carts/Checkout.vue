<script setup lang="ts">
import type { Cart } from '@/types/cart'

const props = defineProps<{
  carts: Array<Cart>
}>()

const paymentMethods = useConstant().paymentMethods

const selectedPaymentmethod = ref(paymentMethods[0])

const availableaddress = useConstant().availableAddress

const cityOptions = useConstant().cityOptions

const provinceOptions = useConstant().provinceOptions

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

let shipping: number = $ref(availableaddress[0].shippingAmount as number)

const orderTotal: number = $computed(() => {
  return shipping + subTotal
})

// checkout form
const checkoutForm = useForm({
  name: useAuthStore().user?.fullName as string,
  email: useAuthStore().user?.email as string,
  orderNumber: 0,
  phone: useAuthStore().user?.phone as string,
  address: useAuthStore().user?.address1,
  city: useAuthStore().user?.city,
  province: useAuthStore().user?.province,
  postalCode: useAuthStore().user?.postalCode,
  country: 'PH',
  paymentMethod: 'cod',

  totalAmount: orderTotal,
  shippingAmount: shipping,
  taxesAmount: 0,

  orderVariants: [] as Array<any>,
})

// watch city, change postalCode base on city value
watch(() => checkoutForm.city, (city) => {
  const address = _.find(availableaddress, (address) => {
    return address.city === city
  }) as any

  checkoutForm.province = address?.province
  checkoutForm.postalCode = address?.postalCode
  shipping = address?.shippingAmount
})

onMounted(() => {
  // TODO: this is a hack to make the form work (for now), will be removed in the future, validate first orderNumber
  checkoutForm.orderNumber = Math.floor(Math.random() * 1000000000) as number

  // set orderVariants
  checkoutForm.orderVariants = _.map(props.carts, (cart) => {
    return {
      variantId: cart.variant.id,
      productId: cart.product.id,
      quantity: cart.quantity,
      price: cart.variant.price,
      total: cart.variant.price * cart.quantity,
    }
  })
})
</script>

<template>
  <div>
    <!-- Background color split screen for large screens -->
    <div class="fixed top-0 left-0 hidden w-1/2 h-full bg-white lg:block" aria-hidden="true" />
    <div class="fixed top-0 right-0 hidden w-1/2 h-full bg-primary-900 lg:block" aria-hidden="true" />

    <div class="relative grid grid-cols-1 mx-auto max-w-7xl gap-x-16 lg:grid-cols-2 lg:px-8 lg:pt-16">
      <h1 class="sr-only">
        Checkout
      </h1>

      <section aria-labelledby="summary-heading" class="py-12 text-primary-300 bg-primary-900 md:px-10 lg:col-start-2 lg:row-start-1 lg:mx-auto lg:w-full lg:max-w-lg lg:bg-transparent lg:px-0 lg:pt-0 lg:pb-24">
        <div class="max-w-2xl px-4 mx-auto lg:max-w-none lg:px-0">
          <h2 id="summary-heading" class="sr-only">
            Order summary
          </h2>

          <dl>
            <dt class="text-sm font-medium">
              Amount due
            </dt>
            <dd class="mt-1 text-3xl font-bold tracking-tight text-white">
              ₱{{ orderTotal.toFixed(2) }}
            </dd>
          </dl>

          <ul role="list" class="text-sm font-medium divide-y divide-white divide-opacity-10">
            <li v-for="cart in carts" :key="cart.id" class="flex items-start py-6 space-x-4">
              <img :src="cart.product.image" :alt="cart.product.name" class="flex-none object-cover object-center w-20 h-20 rounded-md">
              <div class="flex-auto space-y-1">
                <h3 class="text-white">
                  {{ cart.product.name }}
                </h3>
                <p class="line-clamp-1">
                  {{ cart.product.description }}
                </p>
                <p>{{ cart.variant.name }}</p>
              </div>
              <p class="flex-none text-base font-medium text-primary-300">
                ₱{{ cart.variant.price.toFixed(2) }} x {{ cart.quantity }} = <span class="text-white">₱{{ (cart.variant.price * cart.quantity).toFixed(2) }}</span>
              </p>
            </li>
          </ul>

          <dl class="pt-6 space-y-6 text-sm font-medium border-t border-white border-opacity-10">
            <div class="flex items-center justify-between">
              <dt>Subtotal</dt>
              <dd>₱{{ subTotal.toFixed(2) }}</dd>
            </div>

            <div class="flex items-center justify-between">
              <dt>Shipping</dt>
              <dd>₱{{ shipping.toFixed(2) }}</dd>
            </div>

            <div class="flex items-center justify-between">
              <dt>Taxes</dt>
              <dd>₱0.00</dd>
            </div>

            <div class="flex items-center justify-between pt-6 text-white border-t border-white border-opacity-10">
              <dt class="text-base">
                Total
              </dt>
              <dd class="text-base">
                ₱{{ orderTotal.toFixed(2) }}
              </dd>
            </div>
          </dl>
        </div>
      </section>

      <section aria-labelledby="payment-and-shipping-heading" class="py-16 lg:col-start-1 lg:row-start-1 lg:mx-auto lg:w-full lg:max-w-lg lg:pt-0 lg:pb-24">
        <h2 id="payment-and-shipping-heading" class="sr-only">
          Payment and shipping details
        </h2>

        <form @submit.prevent="checkoutForm.post(route('customer.orders.store'))">
          <div class="max-w-2xl px-4 mx-auto lg:max-w-none lg:px-0">
            <div>
              <h3 id="contact-info-heading" class="text-lg font-medium text-gray-900">
                Contact information
              </h3>

              <div class="flex flex-col mt-6 space-y-6">
                <JTextField
                  id="email"
                  v-model="checkoutForm.email"
                  name="email"
                  :error-message="checkoutForm.errors?.email"
                  :is-error="_.has(checkoutForm.errors, 'email')"
                  label="Email address"
                />

                <JTextField
                  id="phone"
                  v-model="checkoutForm.phone"
                  name="phone"
                  placeholder="09"
                  :error-message="checkoutForm.errors?.phone"
                  :is-error="_.has(checkoutForm.errors, 'phone')"
                  label="Phone number"
                />
              </div>
            </div>

            <div class="pt-10 mt-10 border-t border-gray-200">
              <RadioGroup v-model="selectedPaymentmethod">
                <RadioGroupLabel class="text-lg font-medium text-gray-900">
                  Payment method
                </RadioGroupLabel>

                <div class="grid grid-cols-1 mt-4 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                  <RadioGroupOption
                    v-for="paymentMethod in paymentMethods" :key="paymentMethod.id" v-slot="{ checked, active }" :disabled="paymentMethod.disabled" as="template" :value="paymentMethod"
                  >
                    <div
                      class="relative flex p-4 bg-white border rounded-lg shadow-sm cursor-pointer focus:outline-none" :class="[
                        checked ? 'border-transparent' : 'border-gray-300', active ? 'ring-2 ring-primary-500' : '',
                        paymentMethod.disabled ? 'opacity-50' : 'opacity-100']"
                    >
                      <span class="flex flex-1">
                        <span class="flex flex-col">
                          <RadioGroupLabel as="span" class="block text-sm font-medium text-gray-900">{{ paymentMethod.title }}</RadioGroupLabel>
                          <RadioGroupDescription as="span" class="flex items-center mt-1 text-sm text-gray-500">{{ paymentMethod.description }}</RadioGroupDescription>
                        </span>
                      </span>
                      <heroicons-check-circle-20-solid v-if="checked" class="w-5 h-5 text-primary-600" aria-hidden="true" />
                      <span class="absolute rounded-lg pointer-events-none -inset-px" :class="[active ? 'border' : 'border-2', checked ? 'border-primary-500' : 'border-transparent']" aria-hidden="true" />
                    </div>
                  </RadioGroupOption>
                </div>
              </RadioGroup>
            </div>

            <div class="mt-10">
              <h3 class="text-lg font-medium text-gray-900">
                Shipping information
              </h3>

              <div class="grid grid-cols-1 mt-6 gap-y-6 gap-x-4 sm:grid-cols-4">
                <div class="sm:col-span-4">
                  <JTextField
                    id="name"
                    v-model="checkoutForm.name"
                    autocomplete="name"
                    :error-message="checkoutForm.errors?.name"
                    :is-error="_.has(checkoutForm.errors, 'name')"
                    label="Name"
                  />
                </div>

                <div class="sm:col-span-4">
                  <JTextField
                    id="address"
                    v-model="checkoutForm.address"
                    autocomplete="street-address"
                    placeholder="1234 Main St, Brgy. 123"
                    :error-message="checkoutForm.errors?.address"
                    :is-error="_.has(checkoutForm.errors, 'address')"
                    label="Address"
                  />
                </div>

                <div class="sm:col-span-4">
                  <JSelect
                    id="city"
                    v-model="checkoutForm.city"
                    label="Municipality/City"
                    :items="cityOptions"
                  />
                </div>

                <div class="sm:col-span-3">
                  <JSelect
                    id="province"
                    v-model="checkoutForm.province"
                    label="Province"
                    :items="provinceOptions"
                  />
                </div>

                <div class="sm:col-span-1">
                  <JTextField
                    id="postal-code"
                    v-model="checkoutForm.postalCode"
                    autocomplete="postal-code"
                    is-read-only
                    :error-message="checkoutForm.errors?.postalCode"
                    :is-error="_.has(checkoutForm.errors, 'postal_code')"
                    label="Postal code"
                  />
                </div>
              </div>
            </div>

            <div v-if="false" class="mt-10">
              <h3 class="text-lg font-medium text-gray-900">
                Billing information
              </h3>

              <div class="flex items-center mt-6">
                <input id="same-as-shipping" name="same-as-shipping" type="checkbox" checked class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500">
                <div class="ml-2">
                  <label for="same-as-shipping" class="text-sm font-medium text-gray-900">Same as shipping information</label>
                </div>
              </div>
            </div>
            <div class="flex items-center justify-center p-10 mt-6 text-gray-500 border-2 border-dashed rounded-md bg-warning-50">
              <heroicons-exclamation-triangle-20-solid class="mr-2 text-warning-600" />
              <span class="text-lg font-medium ">
                Strictly no cancellation of orders.
              </span>
            </div>
            <div class="flex justify-end pt-6 mt-10 space-x-4 border-t border-gray-200">
              <JLink
                :to="route('customer.carts.index')"
              >
                <JBtn
                  variant="text"
                  return to cart
                  label="Return to cart"
                />
              </JLink>
              <JBtn type="submit" label="Confirm order" />
            </div>
          </div>
        </form>
      </section>
    </div>
  </div>
</template>
