<script setup lang="ts">
const sidebar = useSidebarStore()

let count = $ref(usePage().props.value.pendingOrderCount)
onMounted(() => {
  window.Echo.channel('pending-order-number')
    .listen('.pending.order.number', (e: any) => {
      count = e.pendingOrderNumber
    })
})
</script>

<template>
  <div class="flex flex-shrink-0 h-16 bg-white border-b border-gray-200">
    <button
      type="button"
      class="px-4 text-gray-400 border-r border-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 lg:hidden"
      @click="sidebar.open()"
    >
      <span class="sr-only">Open sidebar</span>
      <heroicons-outline-bars-3-center-left size="24" aria-hidden="true" />
    </button>
    <!-- Search bar -->
    <div class="flex justify-between flex-1 px-4 sm:px-6 lg:mx-auto lg:px-8">
      <div class="flex flex-1">
        <div v-if="false" class="flex w-full md:ml-0">
          <label for="search-field" class="sr-only">Search</label>
          <div class="relative w-full text-gray-400 focus-within:text-gray-600">
            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none" aria-hidden="true">
              <heroicons-magnifying-glass-20-solid class="w-5 h-5" aria-hidden="true" />
            </div>
            <input
              id="search-field" name="search-field"
              class="block w-full h-full py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 border-transparent focus:border-transparent focus:outline-none focus:ring-0 sm:text-sm"
              placeholder="Search transactions" type="search"
            >
          </div>
        </div>
      </div>
      <div class="flex items-center ml-4 md:ml-6">
        <JLink
          :to="route('admin.orders.index')"
          as="button"
          class="p-1 text-gray-400 bg-white rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
        >
          <span class="flex">
            <heroicons-clipboard-document-list class="w-6 h-6" aria-hidden="true" />
            <span class="ml-1">
              {{ count }}
            </span>
          </span>
        </JLink>
        <AppProfileMenu />
      </div>
    </div>
  </div>
</template>
