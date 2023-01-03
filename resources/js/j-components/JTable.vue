<script setup lang="ts">
import type { PaginationLink, TableHeader, TableItems } from './types'

// TODO transfer this type to the types file
interface JTableProps {
  items: Array<TableItems>
  itemKey: string
  headers: Array<TableHeader>
  isLoading?: boolean
  loadingDebounce?: number
  modelValue: Array<string | number>
  indeterminate?: boolean
  links?: Array<PaginationLink>
  emptyDataText?: string
  isPagination?: boolean
  isSelect?: boolean
  isFilter?: boolean
}

// set default props
const props = withDefaults(defineProps<JTableProps>(), {
  isSelect: true,
  isPagination: true,
  isFilter: true,
})

// emits
const emit = defineEmits<{
  (e: 'update:modelValue', value: any): void
  (e: 'deleteAll'): void
}>()

// set loading state
const isProgressLinear = ref(false)

watch(
  () => props.isLoading,
  _.debounce((value) => {
    isProgressLinear.value = value
  }, props.loadingDebounce ?? 1000),
)

// set checkbox state
const indeterminate = computed(() => props.modelValue.length > 0 && props.modelValue.length < Object.keys(props.items as any[])?.length)
const onCheckBoxChange = (e: any) => {
  const { checked } = e.target
  if (checked)
    emit('update:modelValue', props.items?.filter(f => f.status !== 'deleted').map(m => m[props.itemKey]) ?? [])
  else
    emit('update:modelValue', [])
}

const filters = ref<any>({})

const toggleFilter = (id: string) => {
  const isFilterExist = _.has(filters.value, id)

  if (isFilterExist) {
    // remove filter
    filters.value = _.omit(filters.value, id)
  }

  // add filter
  else {
    filters.value = {
      ...filters.value,
      [id]: '',
    }
  }
}

const debounceFilter = useDebounceFn(() => {
  useJTable().filterFetch(filters.value)
}, 500)

watch(
  () => filters.value,
  (value, oldValue) => {
    if (props.isFilter) {
      if (Object.keys(value).length !== Object.keys(oldValue).length)
        useJTable().filterFetch(value)

      else
        debounceFilter()
    }
  },
  { deep: true },
)

onMounted(() => {
  if (props.isFilter)
    filters.value = route().params?.filter ?? {}
})
</script>

<template>
  <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
      <div class="relative overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
        <div
          v-if="modelValue.length > 0"
          class="absolute top-0 flex items-center h-12 space-x-3 left-12 bg-gray-50 sm:left-16"
        >
          <button
            v-if="false"
            type="button"
            class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30"
          >
            Bulk edit
          </button>
          <button
            type="button"
            class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30"
            @click="$emit('deleteAll')"
          >
            Delete all
          </button>
        </div>
        <table class="min-w-full divide-y divide-gray-300 table-fixed">
          <thead class="bg-gray-50">
            <tr>
              <th v-if="props.isSelect" scope="col" class="relative w-12 px-6 sm:w-16 sm:px-8">
                <input
                  type="checkbox"
                  :checked="indeterminate || modelValue.length === items?.length" :indeterminate="indeterminate"
                  class="absolute w-4 h-4 -mt-2 border-gray-300 rounded text-primary-600 left-4 top-1/2 focus:ring-primary-500 sm:left-6"
                  @change="onCheckBoxChange"
                >
              </th>
              <th
                v-for="(header, id) in headers" :key="id" scope="col"
                :class="header.class"
                class="px-3 py-3.5 text-left"
              >
                <div class="inline-flex justify-between w-full ">
                  <JLink
                    v-if="(id !== 0 || modelValue.length === 0)"
                    :to="header.sortable ? useJTable().sortLink(header) : ''"
                    class="inline-flex text-sm font-semibold text-gray-900 group"
                    as="button"
                  >
                    {{ header.text }}
                    <span
                      v-if="header.sortable"
                      class="flex-none ml-2 rounded "
                      :class="[
                        useJTable().isSortExist(header.value)
                          ? 'visible group-hover:bg-gray-300 bg-gray-200 text-gray-900'
                          : 'invisible group-hover:visible  text-gray-400',
                      ]"
                    >
                      <component :is="useJTable().sortIcon(header)" class="w-5 h-5" aria-hidden="true" />
                    </span>
                  </JLink>
                  <button
                    v-if="header.filterable"
                    class="flex-none ml-2 rounded"
                    :class="
                      useJTable().isFilterExist(header.value)
                        ? 'text-primary-600 hover:text-primary-900'
                        : 'text-gray-600 hover:text-gray-900'
                    "
                    @click="toggleFilter(header.value)"
                  >
                    <component
                      :is="useJTable().filterIcon(header.value)"
                      class="w-5 h-5"
                      aria-hidden="true"
                    />
                  </button>
                </div>
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
              v-if="route().params.filter && props.isFilter"
              class="bg-gray-50"
            >
              <td />
              <template
                v-for="header in headers"
                :key="header.value"
              >
                <td
                  v-if="header.value !== 'actions'"
                  :class="header.class"
                  class="py-1.5 text-left"
                >
                  <JTextField
                    v-if="useJTable().isFilterExist(header.value)"
                    :id="header.value"
                    v-model="filters[header.value]"
                    autofocus
                    :placeholder="`Filter ${_.capitalize(header.text)}`"
                    class="max-w-xs py-1"
                    input-class="py-1.5 text-sm"
                    is-clearable
                    :type="header.filterOptions?.type as any ?? 'text'"
                  />
                </td>
              </template>
              <td class="relative pr-4 sm:pr-6 hitespace-nowrap">
                <div class="flex justify-end">
                  <button
                    v-tooltip="'Clear filters'"
                    type="button"
                    class="text-danger-600 hover:text-danger-900"
                    @click="filters = {}"
                  >
                    <heroicons-x-circle-20-solid class="w-6 h-6" />
                  </button>
                </div>
              </td>
            </tr>

            <!-- table selection -->
            <tr
              v-for="item in items" :key="item[props.itemKey]"
              :class="[modelValue.includes(item[props.itemKey]) && 'bg-gray-50']"
            >
              <td v-if="props.isSelect" class="relative w-12 px-6 sm:w-16 sm:px-8">
                <div
                  v-if="modelValue.includes(item[props.itemKey])"
                  class="absolute inset-y-0 left-0 w-0.5 bg-primary-600"
                />

                <input
                  v-if="item?.status !== 'deleted'"
                  type="checkbox"
                  :checked="modelValue.includes(item[props.itemKey])"
                  class="absolute w-4 h-4 -mt-2 border-gray-300 rounded text-primary-600 left-4 top-1/2 focus:ring-primary-500 sm:left-6"
                  :value="item[props.itemKey]"
                  @change="$emit('update:modelValue', ($event.target as HTMLInputElement).checked ? [...modelValue, item[props.itemKey]] : modelValue.filter(f => f !== item[props.itemKey]))"
                >
              </td>

              <!-- table-data area -->
              <slot name="table-data" :item="item" :selected="modelValue.includes(item[props.itemKey])" />
            </tr>

            <!-- callback area -->
            <tr
              v-show="!items?.length"
            >
              <td colspan="100" class="py-4 text-center">
                <div class="grid place-items-center">
                  <img src="/svgs/empty_data.svg" class="w-80 h-80">

                  <div class="text-sm text-gray-400">
                    {{ emptyDataText ?? 'No data available' }}
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <JPagination v-if="props.isPagination" :links="links ?? []" />
</template>
