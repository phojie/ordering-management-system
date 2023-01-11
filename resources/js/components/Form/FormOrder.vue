<script setup lang="ts">
const { form, $v } = useOrderStore()
const processing = $computed(() => useOrderStore().processing)

const paymentMethods = useConstant().paymentMethods

const selectedPaymentmethod = ref(paymentMethods[0])

// watch city, change postalCode base on city value
watch(() => form.city, (city) => {
  const address = _.find(useConstant().availableAddress, (address) => {
    return address.city === city
  }) as any

  form.postalCode = address?.postalCode

  const subTotalAmount = form.totalAmount - form.shippingAmount

  form.shippingAmount = address?.shippingAmount
  form.totalAmount = form.taxesAmount + form.shippingAmount + subTotalAmount
})
</script>

<template>
  <div class="pt-6 pb-5 space-y-6">
    <JSelect
      v-model="form.status"
      label="Status"
      :items="['pending', 'shipped', 'delivered', 'cancelled']"
      :is-disabled="processing"
      default-value="pending"
    />

    <div>
      <h3 class="text-lg font-medium text-gray-900">
        Shipping Information
      </h3>
      <div class="mt-4 space-y-6">
        <JTextField
          id="name"
          v-model="form.name"
          placeholder="Name"
          label="Name"
          :is-disabled="processing"
          :error-message="$v.name.$errors[0]?.$message"
          :is-error="$v.name.$error"
        />

        <JTextField
          id="email"
          v-model="form.email"
          placeholder="Email"
          label="Email"
          :is-disabled="processing"
          :error-message="$v.email.$errors[0]?.$message"
          :is-error="$v.email.$error"
        />

        <JTextField
          id="phone"
          v-model="form.phone"
          placeholder="09"
          label="Phone"
          :is-disabled="processing"
          :error-message="$v.phone.$errors[0]?.$message"
          :is-error="$v.phone.$error"
        />

        <JTextField
          id="address"
          v-model="form.address"
          placeholder="1234 Main St, Brgy. 123"
          label="Address"
          :is-disabled="processing"
          :error-message="$v.address.$errors[0]?.$message"
          :is-error="$v.address.$error"
        />

        <JSelect
          id="city"
          v-model="form.city"
          label="Municipality/City"
          :items="useConstant().cityOptions"
          :is-disabled="processing"
          :error-message="$v.city.$errors[0]?.$message"
          :is-error="$v.city.$error"
        />

        <JSelect
          id="province"
          v-model="form.province"
          label="Province"
          :items="useConstant().provinceOptions"
          :is-disabled="processing"
          :error-message="$v.city.$errors[0]?.$message"
          :is-error="$v.city.$error"
        />

        <JTextField
          id="postal-code"
          v-model="form.postalCode"
          autocomplete="postal-code"
          :error-message="$v.postalCode.$errors[0]?.$message"
          :is-error="$v.postalCode.$error"
          label="Postal code"
        />
      </div>
    </div>

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

    <div>
      <h3 class="text-lg font-medium text-gray-900">
        Shopping cart
      </h3>

      <div class="mt-4 space-y-10">
        <AppOrderList :order-variants="form.orderVariants" />
        <div class="px-4 py-6 border-t border-gray-200 bg-primary-50 sm:px-6">
          <div class="flex justify-between text-sm text-gray-900">
            <p>Shipping Amount</p>
            <p>₱{{ form.shippingAmount?.toFixed(2) }}</p>
          </div>
          <div class="flex justify-between text-sm text-gray-900">
            <p>Taxes Amount</p>
            <p>₱{{ form.taxesAmount?.toFixed(2) }}</p>
          </div>
          <div class="flex justify-between text-xl font-medium text-gray-900">
            <p>Total</p>
            <p>₱{{ form.totalAmount?.toFixed(2) }}</p>
          </div>
          <p class="mt-0.5 text-sm text-gray-500">
            Shipping and taxes calculated at checkout.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
