<script setup lang="ts">
import type { PaginationUsers, User } from '@/types/user'

defineProps<{
  users: PaginationUsers
  edit?: []
}>()

const { formState, form, headers, processing, deleteUsers, deleteUser } = useUserStore()

const selected = ref<any>([])

const deleteAll = () => {
  deleteUsers(selected.value)
  selected.value = []
}

const toggleEdit = (user: User) => {
  form.id = user.id
  form.firstName = user.firstName
  form.middleName = user.middleName
  form.lastName = user.lastName
  form.username = user.username
  form.email = user.email
  form.password = 'password'

  formState.type = 'edit'
  formState.show = true
  formState.title = 'Edit User'
  formState.description = `Edit the details for ${user.fullName}`
}
</script>

<template>
  <section class="flex flex-col px-4 mt-2 space-y-6 sm:px-6 lg:px-8">
    <JTable
      v-model="selected"
      :indeterminate="true"
      :items="users?.data ?? []"
      item-key="id"
      :headers="headers"
      :is-loading="processing"
      :links="users?.meta?.links ?? []"
      @deleteAll="deleteAll()"
    >
      <template #table-data="{ item, selected }">
        <td class="py-4 pr-3 text-sm whitespace-nowrap">
          <div class="flex items-center">
            <div class="flex-shrink-0 w-10 h-10">
              <img
                loading="lazy"
                class="w-10 h-10 rounded-full"
                :src="item.imageUrl" alt="Profile"
              >
            </div>
            <div class="ml-4">
              <div class="font-medium" :class="[selected ? 'text-primary-600' : 'text-gray-900']">
                {{ item.fullName }}
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
          <div class="flex items-center space-x-2 ">
            <button
              :disabled="processing" type="button" class="text-warning-600 hover:text-warning-900"
              @click="toggleEdit(item as any)"
            >
              Edit
              <span class="sr-only">, {{ item.name }}</span>
            </button>

            <button :disabled="processing" type="button" class="text-error-600 hover:text-error-900" @click="deleteUser(item.id)">
              Delete
              <span class="sr-only">, {{ item.name }}</span>
            </button>
          </div>
        </td>
      </template>
    </JTable>
  </section>
</template>
