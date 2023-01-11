<script setup lang="ts">
const props = defineProps<{
  stats: Array<{
    name: string
    stat: number
    previousStat: number
    change: number
    changeType: 'increase' | 'decrease'
  }>
  transactions: Array<{
    id: string
    name: string
    amount: number
    currency: string
    date: string
    datetime: string
    href: string
    status: 'delivered' | 'pending' | 'cancelled' | 'shipped'
  }>
  ordersProductQuantity: {
    categories: Array<any>
    series: Array<any>
  }
}>()

defineOptions({
  layout: AdminLayout,
})

const auth = useAuthStore()

const roleDisplay = computed(() => {
  const roles = auth.roles
  if (_.includes(roles, 'Super Admin'))
    return 'Super Admin'

  return roles.map(r => r.charAt(0).toUpperCase() + r.slice(1)).join(', ')
})

const { formState: formStateProduct } = useProductStore()
const { formState: formStateCategory } = useCategoryStore()
const { formState: formStateOrder } = useOrderStore()

const toggleCreateCategory = () => {
  formStateCategory.show = true
}

const toggleCreateProduct = () => {
  formStateProduct.show = true
}

onMounted(() => {
  window.Echo.channel('new-order')
    .listen('.new.order', (e: any) => {
      // reload
      Inertia.reload()
    })
})
</script>

<template>
  <div>
    <Head title="Home | Admin" />

    <main class="flex-1">
      <!-- Page title & actions -->
      <div class="px-4 py-6 bg-white border-b border-gray-200 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="flex-1 min-w-0">
          <div class="flex space-x-5">
            <div class="flex-shrink-0">
              <img class="w-20 h-20 rounded-full" :src="auth.user?.avatar" alt="profile">
            </div>
            <div class="pt-1 text-left">
              <p class="text-sm font-medium text-gray-600">
                Welcome back,
              </p>
              <p v-motion-fade class="text-2xl font-bold text-gray-900">
                {{ auth.user?.fullName }}
              </p>
              <p class="flex items-center text-sm font-medium text-gray-600 capitalize">
                <heroicons-shield-check-solid class="mr-1 text-success-600" size="18" />
                {{ roleDisplay }}
              </p>
            </div>
          </div>
        </div>
        <div class="flex mt-4 sm:mt-0 sm:ml-4">
          <button
            type="button"
            class="inline-flex items-center order-1 px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm sm:order-0 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:ml-0"
            @click="toggleCreateProduct"
          >
            Add products
          </button>
          <button
            type="button"
            class="inline-flex items-center order-first px-4 py-2 ml-3 text-sm font-medium text-white border border-transparent rounded-md shadow-sm sm:order-last bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
            @click="toggleCreateCategory"
          >
            Create categories
          </button>
        </div>
      </div>

      <section class="flex flex-col px-4 mt-6 space-y-6 sm:px-6 lg:px-8">
        <!-- stats  -->
        <AdminIndexStats :stats="stats" />

        <!-- Charts -->
        <AdminIndexCharts :orders-product-quantity="ordersProductQuantity" />

        <!-- recent activity -->
        <AdminIndexTable :transactions="transactions" />
      </section>

      <!-- Slide category over -->
      <AdminCategoriesSlideOver :state="formStateCategory.show" />

      <!-- Slide product over -->
      <AdminProductsSlideOver :state="formStateProduct.show" />

      <!-- Slide order over -->
      <!-- Slide over -->
      <AdminOrdersSlideOver :state="formStateOrder.show" />
    </main>
  </div>
</template>
