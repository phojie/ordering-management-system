<script setup lang="ts">
import type { Menu } from '@/types/menu'

const props = defineProps<{
  menus?: Menu[]
}>()

const { state, show, hide } = useSlideOver()

const closeSlideOver = () => {
  useMenuStore().resetForm()
  hide()
}
</script>

<template>
  <main class="flex-1">
    <!-- Page title & actions -->
    <div
      class="px-4 py-6 bg-white border-b border-gray-200 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8"
    >
      <div class="flex-1 min-w-0">
        <div class="sm:flex-auto">
          <h1 class="text-xl font-semibold text-gray-900">
            Menu
          </h1>
          <p class="mt-2 text-sm text-gray-700">
            A list of all the menus in your restaurant including their name, title, status, and other
            details.
          </p>
        </div>
      </div>
      <div class="flex mt-4 sm:mt-0 sm:ml-4">
        <!-- search area -->
        <button
          type="button"
          class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary-600 order-0 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:order-1 sm:ml-3"
          @click="show"
        >
          Create
        </button>

        <button
          type="button"
          class="inline-flex items-center p-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary-600 order-0 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:order-1 sm:ml-3"
        >
          <!-- <Icon name="zondicons:reload" :class="[pending ? 'animate-spin' : '']" class="w-5 h-5 " /> -->
        </button>
      </div>
    </div>

    <!-- Table -->
    <AdminMenusTable :menus="props.menus ?? []" />

    <!-- Slide over -->
    <AdminMenusSlideOver :state="state" @hide="closeSlideOver" />
  </main>
</template>
