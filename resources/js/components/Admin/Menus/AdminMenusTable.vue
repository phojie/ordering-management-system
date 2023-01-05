<script setup lang="ts">
const props = defineProps<{
  menus: any[]
}>()

// selected table row
const selectedMenu = ref([] as any[])
const indeterminate = computed(() => selectedMenu.value.length > 0 && selectedMenu.value.length < Object.keys(props.menus as any[])?.length)

const onCheckBoxChange = (e: any) => {
  const { checked } = e.target
  if (checked)
    selectedMenu.value = props.menus?.map(m => m.id) as any[]

  else
    selectedMenu.value = []
}
</script>

<template>
  <section class="flex flex-col px-4 mt-8 space-y-6 sm:px-6 lg:px-8">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
        <div class="relative overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
          <div v-if="selectedMenu.length > 0" class="absolute top-0 flex items-center h-12 space-x-3 left-12 bg-gray-50 sm:left-16">
            <button type="button" class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30">
              Bulk edit
            </button>
            <button type="button" class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30">
              Delete all
            </button>
          </div>
          <table class="min-w-full divide-y divide-gray-300 table-fixed">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="relative w-12 px-6 sm:w-16 sm:px-8">
                  <input
                    type="checkbox"
                    class="absolute w-4 h-4 -mt-2 text-primary-600 border-gray-300 rounded left-4 top-1/2 focus:ring-primary-500 sm:left-6"
                    :checked="indeterminate || selectedMenu.length === menus?.length" :indeterminate="indeterminate"
                    @change="onCheckBoxChange"
                  >
                </th>
                <th scope="col" class="min-w-[12rem] py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">
                  Name
                </th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
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
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="menuData in menus" :key="menuData.id" :class="[selectedMenu.includes(menuData.id) && 'bg-gray-50']">
                <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                  <div v-if="selectedMenu.includes(menuData.id)" class="absolute inset-y-0 left-0 w-0.5 bg-primary-600" />
                  <input
                    v-model="selectedMenu" type="checkbox"
                    class="absolute w-4 h-4 -mt-2 border-gray-300 rounded text-primary-600 left-4 top-1/2 focus:ring-primary-500 sm:left-6"
                    :value="menuData.id"
                  >
                </td>
                <td class="py-4 pr-3 text-sm font-medium whitespace-nowrap" :class="[selectedMenu.includes(menuData.id) ? 'text-primary-600' : 'text-gray-900']">
                  {{ menuData.name }}
                </td>
                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                  {{ menuData.punch_line }}
                </td>
                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                  {{ menuData.description }}
                </td>
                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                  {{ menuData.status }}
                </td>
                <td class="py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                  <a href="#" class="text-primary-600 hover:text-primary-900">Edit<span class="sr-only">, {{ menuData.name }}</span></a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <nav class="flex items-center justify-between px-4 border-t border-gray-200 sm:px-0">
      <div class="flex flex-1 w-0 -mt-px">
        <a href="#" class="inline-flex items-center pt-4 pr-1 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700">
          <Icon name="heroicons:arrow-long-left-20-solid" class="w-5 h-5 mr-3 text-gray-400" aria-hidden="true" />
          Previous
        </a>
      </div>
      <div class="hidden md:-mt-px md:flex">
        <a href="#" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700">1</a>
        <!-- Current: "border-primary-500 text-primary-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
        <a href="#" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-primary-600 border-t-2 border-primary-500" aria-current="page">2</a>
        <a href="#" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700">3</a>
        <span class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent">...</span>
        <a href="#" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700">8</a>
        <a href="#" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700">9</a>
        <a href="#" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700">10</a>
      </div>
      <div class="flex justify-end flex-1 w-0 -mt-px">
        <a href="#" class="inline-flex items-center pt-4 pl-1 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700">
          Next
          <Icon name="heroicons:arrow-long-right-20-solid" class="w-5 h-5 ml-3 text-gray-400" aria-hidden="true" />
        </a>
      </div>
    </nav>
  </section>
</template>
