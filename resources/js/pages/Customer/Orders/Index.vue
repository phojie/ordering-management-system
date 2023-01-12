<script setup lang="ts">
import type { Order } from '@/types/order'

const props = defineProps<{
  orders: Array<Order>
}>()

// flash-message
const pageProps = $computed<any>(() => usePage().props.value)

const flashMessageData = $computed(() => {
  return pageProps.flash.success
})

onMounted(() => {
  if (useAuthStore().signedIn) {
    window.Echo.channel(`orders.${useAuthStore().user.id}`)
      .listen('.order.status.updated', (e: any) => {
        // reload
        Inertia.reload()
      })
  }
})
</script>

<template>
  <div class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8 lg:pb-24">
    <div v-if="flashMessageData" class="w-full pb-10 mt-10 mb-10 border-b-2 border-gray-400 ">
      <h1 class="text-base font-medium text-success-600">
        Thank you!
      </h1>
      <p class="mt-2 text-4xl font-bold tracking-tight">
        It's on the way!
      </p>
      <p class="mt-2 text-base text-gray-500">
        Your order #{{ flashMessageData.orderNumber }} has been placed and will be shipped as soon as possible.
      </p>
    </div>

    <div class="max-w-xl">
      <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
        Order history
      </h1>
      <p class="mt-2 text-sm text-gray-500">
        Check the status of recent orders, manage returns, and download invoices.
      </p>
    </div>

    <div class="mt-16">
      <h2 class="sr-only">
        Recent orders
      </h2>

      <div v-if="orders.length > 0" class="space-y-20">
        <div v-for="order in orders" :key="order.id">
          <h3 class="sr-only">
            Order placed on <time :datetime="order.createdAt">{{ useDateFormat(order.createdAt, 'MMM DD, YYYY').value }}</time>
          </h3>

          <div class="px-4 py-6 rounded-lg bg-gray-50 sm:flex sm:items-center sm:justify-between sm:space-x-6 sm:px-6 lg:space-x-8">
            <dl class="flex-auto space-y-6 text-sm text-gray-600 divide-y divide-gray-200 sm:grid sm:grid-cols-3 sm:gap-x-6 sm:space-y-0 sm:divide-y-0 lg:w-1/2 lg:flex-none lg:gap-x-8">
              <div class="flex justify-between sm:block">
                <dt class="font-medium text-gray-900">
                  Date placed
                </dt>
                <dd class="sm:mt-1">
                  <time :datetime="order.createdAt">{{ useDateFormat(order.createdAt, 'MMM DD, YYYY').value }}</time>
                </dd>
              </div>
              <div class="flex justify-between pt-6 sm:block sm:pt-0">
                <dt class="font-medium text-gray-900">
                  Order number
                </dt>
                <dd class="sm:mt-1">
                  #{{ order.orderNumber }}
                </dd>
              </div>
              <div class="flex justify-between pt-6 font-medium text-gray-900 sm:block sm:pt-0">
                <dt>Total amount</dt>
                <dd class="sm:mt-1">
                  ₱{{ order.totalAmount }}
                </dd>
              </div>
            </dl>
            <a v-if="order.status === 'delivered'" href="#" class="flex items-center justify-center w-full px-4 py-2 mt-6 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:mt-0 sm:w-auto">
              Delivered
              <span class="sr-only">for order {{ order.orderNumber }}</span>
            </a>

            <span v-else class="relative inline-flex w-full mt-6 sm:mt-0 sm:w-auto">
              <a href="#" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 sm:w-auto">
                Processing
                <span class="sr-only">for order {{ order.orderNumber }}</span>
              </a>
              <span class="absolute top-0 right-0 flex w-3 h-3 -mt-1 -mr-1">
                <span class="absolute inline-flex w-full h-full rounded-full opacity-75 animate-ping bg-primary-400" />
                <span class="relative inline-flex w-3 h-3 rounded-full bg-primary-500" />
              </span>
            </span>
          </div>

          <table class="w-full mt-4 text-gray-500 sm:mt-6">
            <caption class="sr-only">
              Products
            </caption>
            <thead class="text-sm text-left text-gray-500 sr-only sm:not-sr-only">
              <tr>
                <th scope="col" class="py-3 pr-8 font-normal sm:w-2/5 lg:w-1/3">
                  Product
                </th>
                <th scope="col" class="hidden w-1/5 py-3 pr-8 font-normal sm:table-cell">
                  Price
                </th>
                <th scope="col" class="hidden py-3 pr-8 font-normal sm:table-cell">
                  Quantity
                </th>
                <th scope="col" class="hidden py-3 pr-8 font-normal sm:table-cell">
                  Status
                </th>
                <th scope="col" class="w-0 py-3 font-normal text-right">
                  Info
                </th>
              </tr>
            </thead>
            <tbody class="text-sm border-b border-gray-200 divide-y divide-gray-200 sm:border-t">
              <tr v-for="orderVariant in order.orderVariants" :key="orderVariant.id">
                <td class="py-6 pr-8">
                  <div class="flex items-center">
                    <img :src="orderVariant.product.image" :alt="orderVariant.product.image" class="object-cover object-center w-16 h-16 mr-6 rounded">
                    <div>
                      <div class="font-medium text-gray-900">
                        {{ orderVariant.product.name }}
                      </div>
                      <div class="mt-1 sm:hidden">
                        ₱{{ orderVariant.price }} x {{ orderVariant.quantity }}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="hidden py-6 pr-8 sm:table-cell">
                  ₱{{ orderVariant.price }}
                </td>
                <td class="hidden py-6 pr-8 sm:table-cell">
                  {{ orderVariant.quantity }}
                </td>
                <td class="hidden py-6 pr-8 sm:table-cell">
                  <JBadge :variant="orderVariant.status === 'pending' ? 'warning' : orderVariant.status === 'cancelled' ? 'danger' : 'success'">
                    {{ orderVariant.status }}
                  </JBadge>
                </td>
                <td class="py-6 font-medium text-right whitespace-nowrap">
                  <JLink
                    :to="route('products.show', {
                      slug: orderVariant.product.slug as string,
                    })"
                    class="text-primary-600"
                  >
                    View <span class="hidden lg:inline">Product</span><span class="sr-only">, {{ orderVariant.product.name }}</span>
                  </JLink>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div v-else class="w-full mt-12">
        <div class="grid place-items-center">
          <img src="/svgs/blank-info.svg" class="w-80 h-80">

          <div class="mt-10 text-lg font-medium text-gray-900">
            You have no orders yet.
            <JLink :to="route('products.index')" class="text-sm font-medium text-primary-600 hover:text-primary-500">
              Shop here
              <span aria-hidden="true"> &rarr;</span>
            </JLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
