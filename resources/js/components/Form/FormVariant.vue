<script setup lang="ts">
const { form } = useProductStore()
const processing = $computed(() => useProductStore().processing)

const addVariant = () => {
  form.variants?.push({
    id: _.uniqueId('variant_'),
    name: '',
    stock: 0,
    price: 0,
    product_id: form.id,
  })
}

const removeVariant = (id: string) => {
  form.variants = form.variants?.filter(variant => variant.id !== id)
}

const variantHeaders = [
  {
    text: 'Name',
    value: 'name',
    class: '!py-1',
  },
  {
    text: 'Stock',
    value: 'stock',
    class: '!py-1',
  },
  {
    text: 'Price',
    value: 'price',
    class: '!py-1',
  },
  {
    text: '',
    value: 'actions',
    class: '!py-1',
  },
]

onMounted(() => {
  if (form.variants?.length === 0)
    addVariant()
})
</script>

<template>
  <div>
    <div
      class="block mb-1 text-sm font-medium text-gray-900"
    >
      Variants
    </div>

    <div class="flex flex-col space-y-4">
      <div>
        <JTable
          :model-value="[]"
          :items="form.variants ?? []"
          item-key="id"
          :is-select="false"
          :is-filter="false"
          :is-pagination="false"
          empty-data-text="No variants added yet."
          :headers="variantHeaders"
        >
          <template #table-data="{ item }">
            <td class="px-3 py-4 text-sm whitespace-nowrap">
              <JTextField
                id="name"
                v-model="item.name"
                placeholder="Name"
                :is-disabled="processing"
              />
            </td>

            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
              <JTextField
                id="stock"
                v-model.number="item.stock"
                placeholder="Stock"
                :is-disabled="processing"
              />
            </td>

            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
              <JTextField
                id="price"
                v-model.number="item.price"
                placeholder="Price"
                :is-disabled="processing"
              />
            </td>

            <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
              <button
                type="button"
                class="text-red-600 hover:text-red-900"
                @click="removeVariant(item.id)"
              >
                <heroicons-trash-20-solid
                  class="w-5 h-5"
                />
              </button>
            </td>
          </template>
        </JTable>
      </div>

      <!-- variant form area -->
      <div class="flex justify-end">
        <JBtn size="sm" @click="addVariant()">
          <span class="flex space-x-2">
            <span>Add variant</span>
            <heroicons-squares-plus-20-solid />
          </span>
        </JBtn>
      </div>
    </div>
  </div>
</template>
