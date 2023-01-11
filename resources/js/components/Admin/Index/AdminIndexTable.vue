<script setup lang="ts">
import type { Order } from '@/types/order'

const props = defineProps<{
  transactions: {
    id: string
    name: string
    amount: number
    currency: string
    date: string
    datetime: string
    href: string
    status: 'delivered' | 'pending' | 'cancelled' | 'shipped'
  }[]
}>()

const statusStyles = {
  delivered: 'bg-green-100 text-green-800',
  pending: 'bg-yellow-100 text-yellow-800',
  cancelled: 'bg-danger-100 text-danger-800',
  shipped: 'bg-blue-100 text-blue-800',
}

const { formState, form, headers, deleteOrders, restoreOrder } = useOrderStore()

const toggleEdit = (order: Order) => {
  form.id = order.id
  form.status = order.status
  form.name = order.name
  form.email = order.email
  form.phone = order.phone
  form.address = order.address
  form.city = order.city
  form.province = order.province
  form.postalCode = order.postalCode
  form.status = order.status

  form.totalAmount = order.totalAmount
  form.taxesAmount = order.taxesAmount
  form.shippingAmount = order.shippingAmount

  form.userId = order.userId

  form.orderVariants = order.orderVariants
  form.user = order.user

  formState.type = 'edit'
  formState.show = true
  formState.title = 'Edit Order'
  formState.description = `Edit the details for order number #${order.orderNumber}`
}

const getById = async (id: string) => {
  await useFetch(route('components.orders.show', id)).get().json().then(({ data }) => {
    toggleEdit(data.value)
  })
}
</script>

<template>
  <div>
    <h2 class="mb-5 text-lg font-medium leading-6 text-gray-900">
      Recent activity
    </h2>

    <!-- Activity list (smallest breakpoint only) -->
    <div class="shadow sm:hidden">
      <ul role="list" class="overflow-hidden divide-y divide-gray-200 shadow sm:hidden">
        <li v-for="transaction in transactions" :key="transaction.id">
          <a
            v-if="useGate().can('order-update')"
            v-tooltip="'Open order'"
            href="#"
            class="block px-4 py-4 bg-white hover:bg-gray-50"
            @click="getById(transaction.id)"
          >
            <span class="flex items-center space-x-4">
              <span class="flex flex-1 space-x-2 truncate">
                <heroicons-shopping-cart class="flex-shrink-0 w-5 h-5 text-gray-400" aria-hidden="true" />
                <span class="flex flex-col text-sm text-gray-500 truncate">
                  <span class="truncate">{{ transaction.name }}</span>
                  <span><span class="font-medium text-gray-900">{{ transaction.amount }}</span> {{
                    transaction.currency }}</span>
                  <time :datetime="transaction.datetime">{{ useDateFormat(transaction.date, 'MMM DD, YYYY | hh:mm a ').value }}</time>
                </span>
              </span>
              <heroicons-chevron-double-right-20-solid class="flex-shrink-0 w-5 h-5 text-gray-400" aria-hidden="true" />
            </span>
          </a>
        </li>
      </ul>

      <nav
        v-if="false"
        class="flex items-center justify-between px-4 py-3 bg-white border-t border-gray-200"
        aria-label="Pagination"
      >
        <div class="flex justify-between flex-1">
          <a
            href="#"
            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500"
          >Previous</a>
          <a
            href="#"
            class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500"
          >Next</a>
        </div>
      </nav>
    </div>

    <!-- Activity table (small breakpoint and up) -->
    <div class="hidden sm:block">
      <div class="flex flex-col ">
        <div class="min-w-full overflow-hidden overflow-x-auto align-middle shadow sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr>
                <th
                  class="px-6 py-3 text-sm font-semibold text-left text-gray-900 bg-gray-50"
                  scope="col"
                >
                  Transaction
                </th>
                <th
                  class="px-6 py-3 text-sm font-semibold text-right text-gray-900 bg-gray-50"
                  scope="col"
                >
                  Amount
                </th>
                <th
                  class="hidden px-6 py-3 text-sm font-semibold text-left text-gray-900 bg-gray-50 md:block"
                  scope="col"
                >
                  Status
                </th>
                <th
                  class="px-6 py-3 text-sm font-semibold text-right text-gray-900 bg-gray-50"
                  scope="col"
                >
                  Date
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="transaction in transactions" :key="transaction.id" class="bg-white">
                <td class="w-full px-6 py-4 text-sm text-gray-900 max-w-0 whitespace-nowrap">
                  <div class="flex">
                    <a
                      v-if="useGate().can('order-update')"
                      v-tooltip="'Open order'"
                      href="#"
                      class="inline-flex space-x-2 text-sm truncate group"
                      @click="getById(transaction.id)"
                    >
                      <heroicons-shopping-cart
                        class="flex-shrink-0 w-5 h-5 text-gray-400 group-hover:text-gray-500"
                        aria-hidden="true"
                      />
                      <p class="text-gray-500 truncate group-hover:text-gray-900">{{
                        transaction.name }}</p>
                    </a>
                  </div>
                </td>
                <td class="px-6 py-4 text-sm text-right text-gray-500 whitespace-nowrap">
                  <span class="font-medium text-gray-900">{{ transaction.amount.toFixed(2) }}</span>
                  {{ transaction.currency }}
                </td>
                <td class="hidden px-6 py-4 text-sm text-gray-500 whitespace-nowrap md:block">
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize"
                    :class="[statusStyles[transaction.status]]"
                  >{{ transaction.status }}</span>
                </td>
                <td class="px-6 py-4 text-sm text-right text-gray-500 whitespace-nowrap">
                  <time :datetime="transaction.datetime">  {{ useDateFormat(transaction.date, 'MMM DD, YYYY - hh:mm a ').value }}</time>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- Pagination -->
          <nav
            v-if="false"
            class="flex items-center justify-between px-4 py-3 bg-white border-t border-gray-200 sm:px-6"
            aria-label="Pagination"
          >
            <div class="hidden sm:block">
              <p class="text-sm text-gray-700">
                Showing
                {{ ' ' }}
                <span class="font-medium">1</span>
                {{ ' ' }}
                to
                {{ ' ' }}
                <span class="font-medium">10</span>
                {{ ' ' }}
                of
                {{ ' ' }}
                <span class="font-medium">20</span>
                {{ ' ' }}
                results
              </p>
            </div>
            <div class="flex justify-between flex-1 sm:justify-end">
              <a
                href="#"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
              >Previous</a>
              <a
                href="#"
                class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
              >Next</a>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>
