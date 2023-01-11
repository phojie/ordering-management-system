<script setup lang="ts">
import type { Order, PaginationOrders } from '@/types/order'
defineProps<{
  orders: PaginationOrders
}>()

const { formState, form, headers, deleteOrders } = useOrderStore()
const processing = toRef(useOrderStore(), 'processing')
const selected = ref<any>([])

const deleteAll = () => {
  deleteOrders(selected.value)
  selected.value = []
}

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
  <section class="flex flex-col px-4 space-y-6 sm:px-6 lg:px-8">
    <JTable
      v-model="selected"
      empty-data-text="No orders found."
      :indeterminate="true"
      :items="orders?.data ?? []"
      item-key="id"
      :headers="headers"
      :is-loading="processing"
      :links="orders?.meta?.links ?? []"
      @deleteAll="deleteAll()"
    >
      <template #table-data="{ item, selected }">
        <td class="px-3 py-4 text-sm font-medium whitespace-nowrap">
          <span :class="[selected ? 'text-primary-600' : 'text-gray-900']">
            #{{ item.orderNumber }}
          </span>
        </td>
        <td class="py-4 pr-3 text-sm whitespace-nowrap">
          <div class="flex items-center">
            <div class="flex-shrink-0 w-10 h-10">
              <img
                class="w-10 h-10 rounded-full"
                :src="item.user.avatar"
                loading="lazy"
                alt="…"
              >
            </div>
            <div class="ml-4">
              <div class="font-medium">
                {{ item.user.fullName }}
              </div>
              <div class="text-gray-500">
                {{ item.user.email }}
              </div>
            </div>
          </div>
        </td>
        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          {{ item.orderVariants.length }}
        </td>

        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          ₱{{ item.totalAmount }}
        </td>

        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          <JBadge :variant="item.status === 'pending' ? 'warning' : item.status === 'cancelled' ? 'danger' : 'success'">
            {{ item.status }}
          </JBadge>
        </td>

        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          {{ useDateFormat(item.createdAt, 'MMM DD, YYYY | hh:mm a ').value }}
        </td>

        <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
          <button
            v-if="useGate().can('order-update')"
            v-tooltip="'Edit order'"
            type="button"
            class="text-primary-600 hover:text-primary-900"
            @click="getById(item.id)"
          >
            <heroicons-pencil-square-20-solid class="w-5 h-5" />
          </button>
        </td>
      </template>
    </JTable>
  </section>
</template>
