<script setup lang="ts">
import type { OrderVariant } from '@/types/orderVariant'

const props = defineProps<{
  orderVariants: Array<OrderVariant>
}>()
</script>

<template>
  <div class="flow-root">
    <ul role="list" class="-my-6 divide-y divide-gray-200">
      <li v-for="orderVariant in orderVariants" :key="orderVariant.id" class="flex py-6">
        <div class="flex-shrink-0 w-24 h-24 overflow-hidden border border-gray-200 rounded-md">
          <img :src="orderVariant.product.image" :alt="orderVariant.product.name" class="object-cover object-center w-full h-full">
        </div>

        <div class="flex flex-col flex-1 ml-4">
          <div>
            <div class="flex justify-between text-base font-medium text-gray-900">
              <h3>
                <a
                  :href="route('products.show', {
                    slug:
                      orderVariant.product.slug as string,
                  })"
                  target="_blank"
                >
                  {{ orderVariant.product.name }}
                </a>
              </h3>
              <p class="ml-4">
                ₱{{ orderVariant.variant.price }} x {{ orderVariant.quantity }} = ₱{{ orderVariant.total.toFixed(2) }}
              </p>
            </div>
            <p class="mt-1 text-sm text-gray-500">
              {{ orderVariant.variant.name }}
            </p>
          </div>
          <div class="flex items-end justify-between flex-1 text-sm">
            <p class="text-gray-500">
              Qty {{ orderVariant.quantity }}
            </p>

            <!-- <div class="flex">
              <button type="button" class="font-medium text-primary-600 hover:text-primary-500">
                Remove
              </button>
            </div> -->
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>
