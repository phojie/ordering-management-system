<script setup lang="ts">
import type { TableHeader, TableItems } from './types'
const props = defineProps<{
  items: Array<TableItems>
  itemKey: string
  headers: Array<TableHeader>
  isLoading?: boolean
  loadingDebounce?: number
}>()

// selected table row
const selectedMenu = ref([] as any[])
const indeterminate = computed(() => selectedMenu.value.length > 0 && selectedMenu.value.length < Object.keys(props.items as any[])?.length)
const onCheckBoxChange = (e: any) => {
  const { checked } = e.target
  if (checked)
    selectedMenu.value = props.items?.map(m => m[props.itemKey]) ?? []
  else
    selectedMenu.value = []
}

// set loading state
let isProgressLinear = $ref(false)
watch(
  () => props.isLoading,
  _.debounce((value) => {
    isProgressLinear = value
  }, props.loadingDebounce ?? 1000),
)
</script>

<template>
  <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
      <div class="relative overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
        <div
          v-if="selectedMenu.length > 0"
          class="absolute top-0 flex items-center h-12 space-x-3 left-12 bg-gray-50 sm:left-16"
        >
          <button
            type="button"
            class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30"
          >
            Bulk edit
          </button>
          <button
            type="button"
            class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30"
          >
            Delete all
          </button>
        </div>
        <table class="min-w-full divide-y divide-gray-300 table-fixed">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="relative w-12 px-6 sm:w-16 sm:px-8">
                <input
                  type="checkbox"
                  class="absolute w-4 h-4 -mt-2 text-indigo-600 border-gray-300 rounded left-4 top-1/2 focus:ring-indigo-500 sm:left-6"
                  :checked="indeterminate || selectedMenu.length === items?.length" :indeterminate="indeterminate"
                  @change="onCheckBoxChange"
                >
              </th>
              <th
                v-for="(header, id) in headers" :key="id" scope="col"
                :class="header.class"
              >
                {{ header.text }}
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <!-- progress linear area -->
            <tr>
              <td
                v-show="isProgressLinear"
                :colspan="headers.length + 1"
                class="relative"
              >
                <JProgressLinear
                  class="absolute bg-transparent"
                />
              </td>
            </tr>

            <tr
              v-for="item in items" :key="item[props.itemKey]"
              :class="[selectedMenu.includes(item[props.itemKey]) && 'bg-gray-50']"
            >
              <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                <div
                  v-if="selectedMenu.includes(item[props.itemKey])"
                  class="absolute inset-y-0 left-0 w-0.5 bg-primary-600"
                />
                <input
                  v-model="selectedMenu" type="checkbox"
                  class="absolute w-4 h-4 -mt-2 border-gray-300 rounded text-primary-600 left-4 top-1/2 focus:ring-primary-500 sm:left-6"
                  :value="item[props.itemKey]"
                >
              </td>

              <!-- table-data area -->
              <slot name="table-data" :item="item" :selected="selectedMenu.includes(item[props.itemKey])" />
            </tr>

            <!-- callback area -->
            <tr
              v-show="!items?.length"
            >
              <td colspan="100" class="py-4 text-center">
                <div class="text-sm text-gray-400">
                  No data available
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
