<script setup lang="ts">
import type { Pagination } from '@/types/user'
defineProps<{
  users: Pagination
}>()

const user = useUser()

let selected = $ref([] as any[])
const deleteAll = () => {
  user.deleteUsers(selected)
  selected = []
}
</script>

<template>
  <section class="flex flex-col px-4 mt-2 space-y-6 sm:px-6 lg:px-8">
    <JTable
      v-model="selected"
      :indeterminate="true"
      :items="users?.data ?? []"
      item-key="id"
      :headers="user.headers"
      :is-loading="user.processing"
      :links="users?.meta?.links ?? []"
      @deleteAll="deleteAll()"
    >
      <template #table-data="{ item, selected }">
        <td class="py-4 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-6">
          <div class="flex items-center">
            <div class="flex-shrink-0 w-10 h-10">
              <img
                class="w-10 h-10 rounded-full"
                :src="`https://robohash.org/${item?.id}?set=set3&bgset=bg2&size=400x400`" alt="Profile"
              >
            </div>
            <div class="ml-4">
              <div class="font-medium" :class="[selected ? 'text-primary-600' : 'text-gray-900']">
                {{ item.username }}
              </div>
              <div class="text-gray-500">
                {{ item.email }}
              </div>
            </div>
          </div>
        </td>
        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          <div class="text-gray-900">
            Front-end Developer
          </div>
          <div class="text-gray-500">
            Optimization
          </div>
        </td>
        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
        <!-- Role row -->
        </td>
        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          <span
            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full"
          >Active</span>
        </td>
        <td class="px-3 py-4 text-sm font-medium whitespace-nowrap">
          <div class="flex items-center justify-center space-x-2 ">
            <a href="#" class="text-primary-600 hover:text-primary-900">Edit<span class="sr-only">,
              {{ item.name }}</span></a>

            <button type="button" class="text-error-600 hover:text-error-900" @click="user.deleteUser(item.id)">
              Delete
              <span class="sr-only">, {{ item.name }}</span>
            </button>
          </div>
        </td>
      </template>
    </JTable>
  </section>
</template>
