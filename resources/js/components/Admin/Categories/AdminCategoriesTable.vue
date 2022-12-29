<script setup lang="ts">
import type { Category, PaginationCategories } from '@/types/category'
defineProps<{
  categories: PaginationCategories
}>()

const { formState, form, headers, deleteCategories, restoreCategory } = useCategoryStore()
const processing = toRef(useCategoryStore(), 'processing')
const selected = ref<any>([])

const deleteAll = () => {
  deleteCategories(selected.value)
  selected.value = []
}

const toggleEdit = (category: Category) => {
  form.id = category.id
  form.name = category.name
  form.description = category.description

  form.items = category.items

  formState.type = 'edit'
  formState.show = true
  formState.title = 'Edit Category'
  formState.description = `Edit the details for ${category.name}`
}

const getById = async (id: number) => {
  await useFetch(route('components.categories.show', id)).get().json().then(({ data }) => {
    toggleEdit(data.value)
  })
}
</script>

<template>
  <section class="flex flex-col px-4 space-y-6 sm:px-6 lg:px-8">
    <JTable
      v-model="selected"
      empty-data-text="No categories found."
      :indeterminate="true"
      :items="categories?.data ?? []"
      item-key="id"
      :headers="headers"
      :is-loading="processing"
      :links="categories?.meta?.links ?? []"
      @deleteAll="deleteAll()"
    >
      <template #table-data="{ item, selected }">
        <td class="flex items-center py-4 pr-3 space-x-3 text-sm whitespace-nowrap">
          <span
            :style="`background-color:${item.color}`"
            :class="{ 'bg-gray-400': !item.color }"
            class="w-2 h-2 -mx-1 rounded-full "
          />
          <span class="font-medium" :class="[selected ? 'text-primary-600' : 'text-gray-900']">
            {{ item.name }}
          </span>
        </td>

        <td class="w-1/3 px-3 py-4 text-sm text-gray-500 whitespace-normal">
          <p class="line-clamp-1">
            {{ item.description }}
          </p>
        </td>

        <td class="px-3 py-4 text-sm text-gray-500 whitespace-normal ">
          <JBadge class="!rounded-md" variant="primary">
            {{ item.itemsCount }}
          </JBadge>
        </td>

        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          <JBadge
            :label="item.status === 'deleted' ? 'Archived' : item.status"
            :variant="item.status === 'active' ? 'success' : 'warning'"
            :class="item.status === 'active' ? '!font-semibold' : ''"
          />
        </td>

        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          {{ useDateFormat(item.createdAt, 'MMM DD, YYYY').value }}
        </td>

        <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
          <button
            v-if="item.status === 'active' && useGate().can('category-update')"
            v-tooltip="'Edit category'"
            type="button"
            class="text-primary-600 hover:text-primary-900"
            @click="getById(item.id)"
          >
            <heroicons-pencil-square-20-solid class="w-5 h-5" />
          </button>

          <button
            v-else-if="item.status === 'deleted' && useGate().can('category-delete')"
            v-tooltip="'Restore category'"
            type="button"
            class="text-warning-600 hover:text-warning-900"
            @click="restoreCategory(item.id)"
          >
            <heroicons-arrow-path-rounded-square-20-solid class="w-5 h-5" />
          </button>
        </td>
      </template>
    </JTable>
  </section>
</template>
