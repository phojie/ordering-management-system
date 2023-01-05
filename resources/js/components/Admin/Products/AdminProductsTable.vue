<script setup lang="ts">
import type { PaginationProducts, Product } from '@/types/product'
defineProps<{
  products: PaginationProducts
}>()

const { formState, form, headers, deleteProducts, restoreProduct } = useProductStore()
const processing = toRef(useProductStore(), 'processing')
const selected = ref<any>([])

const deleteAll = () => {
  deleteProducts(selected.value)
  selected.value = []
}

const toggleEdit = (product: Product) => {
  form.id = product.id
  form.name = product.name
  form.status = product.status
  form.description = product.description
  form.image = product.image

  form.variants = product.variants
  form.categories = product.categories

  formState.type = 'edit'
  formState.show = true
  formState.title = 'Edit Product'
  formState.description = `Edit the details for ${product.name}`
}

const getById = async (id: number) => {
  await useFetch(route('components.products.show', id)).get().json().then(({ data }) => {
    toggleEdit(data.value)
  })
}
</script>

<template>
  <section class="flex flex-col px-4 space-y-6 sm:px-6 lg:px-8">
    <JTable
      v-model="selected"
      empty-data-text="No products found."
      :indeterminate="true"
      :items="products?.data ?? []"
      item-key="id"
      :headers="headers"
      :is-loading="processing"
      :links="products?.meta?.links ?? []"
      @deleteAll="deleteAll()"
    >
      <template #table-data="{ item, selected }">
        <td class="py-4 pr-3 text-sm whitespace-nowrap">
          <div class="flex items-center">
            <div class="flex-shrink-0 w-10 h-10">
              <img
                class="w-10 h-10 rounded-md"
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
              v-for="category in item.categories"
              :key="category.id"
              class="cursor-pointer group !text-gray-500"
            >
              <span
                :style="`background-color:${category.color}`"
                :class="{ 'bg-gray-400': !category.color }"
                class="w-2 h-2 mr-1 rounded-full"
              />
              <span
                class="mr-1 text-gray-900 group-hover:underline underline-offset-4"
              > {{ category.name }} </span>
            </JBadge>
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
              <span>{{ variant.stock }}</span> <span v-if="variant.stock === 0" class="ml-1 italic normal-case text-danger-400"> - Out of stock</span>
            </JBadge>
          </div>
          <div v-else class="text-xs italic font-semibold text-danger-400">
            Not available
          </div>
        </td>

        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          <JBadge
            :label="item.status === 'deleted' ? 'Archived' : item.status"
            :variant="item.status === 'active' ? 'success' : item.status === 'inactive' ? 'danger' : 'warning'"
            :class="item.status === 'active' ? '!font-semibold' : ''"
          />
        </td>

        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          {{ useDateFormat(item.createdAt, 'MMM DD, YYYY').value }}
        </td>

        <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
          <button
            v-if="item.status === 'active' && useGate().can('product-update')"
            v-tooltip="'Edit product'"
            type="button"
            class="text-primary-600 hover:text-primary-900"
            @click="getById(item.id)"
          >
            <heroicons-pencil-square-20-solid class="w-5 h-5" />
          </button>
          <button
            v-else-if="item.status === 'deleted' && useGate().can('product-delete')"
            v-tooltip="'Restore product'"
            type="button"
            class="text-warning-600 hover:text-warning-900"
            @click="restoreProduct(item.id)"
          >
            <heroicons-arrow-path-rounded-square-20-solid class="w-5 h-5" />
          </button>
        </td>
      </template>
    </JTable>
  </section>
</template>
