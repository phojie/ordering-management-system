<script setup lang="ts">
import type { TableHeader, TableItems } from './types'
const props = defineProps<{
  items: Array<TableItems>
  itemKey: string
  headers: Array<TableHeader>
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
                class="min-w-[12rem] py-3.5 pr-3 text-left text-sm font-semibold text-gray-900"
              >
                {{ header.text }}
              </th>
              <!-- <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                Punch line
              </th>
              <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                Description
              </th>
              <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                Status
              </th>
              <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                <span class="sr-only">Edit</span>
              </th> -->
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr
              v-for="itemData in items" :key="itemData[props.itemKey]"
              :class="[selectedMenu.includes(itemData[props.itemKey]) && 'bg-gray-50']"
            >
              <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                <div
                  v-if="selectedMenu.includes(itemData[props.itemKey])"
                  class="absolute inset-y-0 left-0 w-0.5 bg-primary-600"
                />
                <input
                  v-model="selectedMenu" type="checkbox"
                  class="absolute w-4 h-4 -mt-2 border-gray-300 rounded text-primary-600 left-4 top-1/2 focus:ring-primary-500 sm:left-6"
                  :value="itemData[props.itemKey]"
                >
              </td>
              <td
                v-for="(header, id) in headers" :key="id" class="py-4 pr-3 text-sm font-medium whitespace-nowrap"
                :class="[selectedMenu.includes(itemData[props.itemKey]) ? 'text-primary-600' : 'text-gray-900']"
              >
                {{ itemData[header.value] }}
              </td>

              <!-- <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                          {{ itemData.username }}
                        </td> -->
              <!-- <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                          {{ itemData.description }}
                        </td>
                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                          {{ itemData.status }}
                        </td> -->
              <td class="py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                <a href="#" class="text-primary-600 hover:text-primary-900">Edit<span class="sr-only">,
                  {{ itemData.name }}</span></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <JPagination />
</template>
