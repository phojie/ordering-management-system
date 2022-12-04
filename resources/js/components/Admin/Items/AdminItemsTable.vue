<script setup lang="ts">
import type { Item, PaginationItems } from '@/types/item'
defineProps<{
  items: PaginationItems
}>()

const { formState, form, headers, deleteItems, restoreItem } = useItemStore()
const processing = toRef(useItemStore(), 'processing')
const selected = ref<any>([])

const deleteAll = () => {
  deleteItems(selected.value)
  selected.value = []
}

const toggleEdit = (item: Item) => {
  form.id = item.id
  form.name = item.name
  form.description = item.description
  form.variants = item.variants

  formState.type = 'edit'
  formState.show = true
  formState.title = 'Edit Item'
  formState.description = `Edit the details for ${item.name}`
}

const getById = async (id: number) => {
  await useFetch(route('components.items.show', id)).get().json().then(({ data }) => {
    toggleEdit(data.value)
  })
}
</script>

<template>
  <section class="flex flex-col px-4 space-y-6 sm:px-6 lg:px-8">
    <JTable
      v-model="selected"
      empty-data-text="No items found."
      :indeterminate="true"
      :items="items?.data ?? []"
      item-key="id"
      :headers="headers"
      :is-loading="processing"
      :links="items?.meta?.links ?? []"
      @deleteAll="deleteAll()"
    >
      <template #table-data="{ item, selected }">
        <td class="py-4 pr-3 text-sm whitespace-nowrap">
          <div class="flex items-center">
            <div class="flex-shrink-0 w-10 h-10">
              <img
                class="w-10 h-10 rounded-full"
                :src="item.image"
                loading="lazy"
                alt="…"
              >
            </div>
            <div class="ml-4">
              <div class="font-medium" :class="[selected ? 'text-primary-600' : 'text-gray-900']">
                {{ item.name }}
              </div>
              <div class="text-gray-500">
                {{ item.description }}
              </div>
            </div>
          </div>
        </td>

        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          <div class="inline-flex space-x-5">
            <JBadge
              v-for="variant in item.variants"
              :key="variant.id"
              class="cursor-pointer group !text-gray-500"
            >
              <span
                :style="`background-color:${variant.color}`"
                :class="{ 'bg-gray-400': !variant.color }"
                class="w-2 h-2 mr-1 rounded-full"
              />
              <span
                class="mr-1 text-gray-900 group-hover:underline underline-offset-4"
              > {{ variant.name }} </span>
              <span class="group-hover:text-primary-600">-₱ {{ variant.price }}</span>
            </JBadge>
          </div>
        </td>

        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          <div v-if="(item.variants.length > 0)" class="inline-flex space-x-2">
            <JBadge
              v-for="variant in item.variants"
              :key="variant.id"
            >
              <span
                :style="`background-color:${variant.color}`"
                :class="{ 'bg-gray-400': !variant.color }"
                class="w-2 h-2 mr-2 rounded-full"
              />
              <span>{{ variant.stock }}</span>
            </JBadge>
          </div>
          <div v-else class="text-xs italic font-semibold text-danger-400">
            Not available
          </div>
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
            v-if="item.status === 'active'"
            v-tooltip="'Edit item'"
            type="button"
            class="text-primary-600 hover:text-primary-900"
            @click="getById(item.id)"
          >
            <heroicons-pencil-square-20-solid class="w-5 h-5" />
          </button>

          <button
            v-else-if="item.status === 'deleted'"
            v-tooltip="'Restore item'"
            type="button"
            class="text-warning-600 hover:text-warning-900"
            @click="restoreItem(item.id)"
          >
            <heroicons-arrow-path-rounded-square-20-solid class="w-5 h-5" />
          </button>
        </td>
      </template>
    </JTable>
  </section>
</template>
