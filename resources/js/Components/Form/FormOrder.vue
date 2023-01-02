<script setup lang="ts">
const props = defineProps<{
  modelValue?: boolean
}>()

const deliveryMethods = [
  { id: 1, title: 'Standard', turnaround: '4–10 business days', price: '$5.00' },
  { id: 2, title: 'Express', turnaround: '2–5 business days', price: '$16.00' },
]
const selectedDeliveryMethod = ref(deliveryMethods[0])

const paymentMethods = [
  { id: 'credit-card', title: 'Credit card' },
  { id: 'paypal', title: 'PayPal' },
  { id: 'etransfer', title: 'eTransfer' },
]
</script>

<template>
  <div>
    <div>
      <h2 class="text-lg font-medium text-gray-900">
        Contact information
      </h2>

      <div class="mt-4">
        <label for="email-address" class="block text-sm font-medium text-gray-700">Email address</label>
        <div class="mt-1">
          <input id="email-address" type="email" name="email-address" autocomplete="email" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
      </div>
    </div>

    <div class="pt-10 mt-10 border-t border-gray-200">
      <h2 class="text-lg font-medium text-gray-900">
        Shipping information
      </h2>

      <div class="grid grid-cols-1 mt-4 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
        <div>
          <label for="first-name" class="block text-sm font-medium text-gray-700">First name</label>
          <div class="mt-1">
            <input id="first-name" type="text" name="first-name" autocomplete="given-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>

        <div>
          <label for="last-name" class="block text-sm font-medium text-gray-700">Last name</label>
          <div class="mt-1">
            <input id="last-name" type="text" name="last-name" autocomplete="family-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>

        <div class="sm:col-span-2">
          <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
          <div class="mt-1">
            <input id="company" type="text" name="company" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>

        <div class="sm:col-span-2">
          <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
          <div class="mt-1">
            <input id="address" type="text" name="address" autocomplete="street-address" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>

        <div class="sm:col-span-2">
          <label for="apartment" class="block text-sm font-medium text-gray-700">Apartment, suite, etc.</label>
          <div class="mt-1">
            <input id="apartment" type="text" name="apartment" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>

        <div>
          <label for="city" class="block text-sm font-medium text-gray-700">City</label>
          <div class="mt-1">
            <input id="city" type="text" name="city" autocomplete="address-level2" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>

        <div>
          <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
          <div class="mt-1">
            <select id="country" name="country" autocomplete="country-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
              <option>United States</option>
              <option>Canada</option>
              <option>Mexico</option>
            </select>
          </div>
        </div>

        <div>
          <label for="region" class="block text-sm font-medium text-gray-700">State / Province</label>
          <div class="mt-1">
            <input id="region" type="text" name="region" autocomplete="address-level1" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>

        <div>
          <label for="postal-code" class="block text-sm font-medium text-gray-700">Postal code</label>
          <div class="mt-1">
            <input id="postal-code" type="text" name="postal-code" autocomplete="postal-code" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>

        <div class="sm:col-span-2">
          <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
          <div class="mt-1">
            <input id="phone" type="text" name="phone" autocomplete="tel" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>
      </div>
    </div>

    <div class="pt-10 mt-10 border-t border-gray-200">
      <RadioGroup v-model="selectedDeliveryMethod">
        <RadioGroupLabel class="text-lg font-medium text-gray-900">
          Delivery method
        </RadioGroupLabel>

        <div class="grid grid-cols-1 mt-4 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
          <RadioGroupOption v-for="deliveryMethod in deliveryMethods" :key="deliveryMethod.id" v-slot="{ checked, active }" as="template" :value="deliveryMethod">
            <div class="relative flex p-4 bg-white border rounded-lg shadow-sm cursor-pointer focus:outline-none" :class="[checked ? 'border-transparent' : 'border-gray-300', active ? 'ring-2 ring-indigo-500' : '']">
              <span class="flex flex-1">
                <span class="flex flex-col">
                  <RadioGroupLabel as="span" class="block text-sm font-medium text-gray-900">{{ deliveryMethod.title }}</RadioGroupLabel>
                  <RadioGroupDescription as="span" class="flex items-center mt-1 text-sm text-gray-500">{{ deliveryMethod.turnaround }}</RadioGroupDescription>
                  <RadioGroupDescription as="span" class="mt-6 text-sm font-medium text-gray-900">{{ deliveryMethod.price }}</RadioGroupDescription>
                </span>
              </span>
              <CheckCircleIcon v-if="checked" class="w-5 h-5 text-indigo-600" aria-hidden="true" />
              <span class="absolute rounded-lg pointer-events-none -inset-px" :class="[active ? 'border' : 'border-2', checked ? 'border-indigo-500' : 'border-transparent']" aria-hidden="true" />
            </div>
          </RadioGroupOption>
        </div>
      </RadioGroup>
    </div>

    <!-- Payment -->
    <div class="pt-10 mt-10 border-t border-gray-200">
      <h2 class="text-lg font-medium text-gray-900">
        Payment
      </h2>

      <fieldset class="mt-4">
        <legend class="sr-only">
          Payment type
        </legend>
        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
          <div v-for="(paymentMethod, paymentMethodIdx) in paymentMethods" :key="paymentMethod.id" class="flex items-center">
            <input v-if="paymentMethodIdx === 0" :id="paymentMethod.id" name="payment-type" type="radio" :checked="true" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
            <input v-else :id="paymentMethod.id" name="payment-type" type="radio" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
            <label :for="paymentMethod.id" class="block ml-3 text-sm font-medium text-gray-700">{{ paymentMethod.title }}</label>
          </div>
        </div>
      </fieldset>

      <div class="grid grid-cols-4 mt-6 gap-y-6 gap-x-4">
        <div class="col-span-4">
          <label for="card-number" class="block text-sm font-medium text-gray-700">Card number</label>
          <div class="mt-1">
            <input id="card-number" type="text" name="card-number" autocomplete="cc-number" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>

        <div class="col-span-4">
          <label for="name-on-card" class="block text-sm font-medium text-gray-700">Name on card</label>
          <div class="mt-1">
            <input id="name-on-card" type="text" name="name-on-card" autocomplete="cc-name" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>

        <div class="col-span-3">
          <label for="expiration-date" class="block text-sm font-medium text-gray-700">Expiration date (MM/YY)</label>
          <div class="mt-1">
            <input id="expiration-date" type="text" name="expiration-date" autocomplete="cc-exp" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>

        <div>
          <label for="cvc" class="block text-sm font-medium text-gray-700">CVC</label>
          <div class="mt-1">
            <input id="cvc" type="text" name="cvc" autocomplete="csc" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
