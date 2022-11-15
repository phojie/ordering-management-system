<script setup lang="ts">
import type { PaginationUsers, User } from '@/types/user'
defineProps<{
  users: PaginationUsers
}>()

const { formState, form, headers, deleteUsers, deleteUser, restoreUser } = useUserStore()
const processing = toRef(useUserStore(), 'processing')
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
  <section class="flex flex-col px-4 space-y-6 sm:px-6 lg:px-8">
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
          <JBadge
            :label="item.status" :variant="item.status === 'active' ? 'success' : 'danger'"
            :class="item.status === 'active' ? '!font-semibold' : ''"
          />
        </td>
        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          <!-- Role row --> Member
        </td>
        <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
          <button
            v-if="item.status === 'active'" :disabled="processing" type="button"
            class="text-primary-600 hover:text-primary-900" @click="toggleEdit(item as any)"
          >
            <!-- <heroicons-pencil-square-20-solid class="w-5 h-5" /> -->
            Edit
            <span class="sr-only">, {{ item.name }}</span>
          </button>

          <button
            v-if="item.status === 'deleted'" :disabled="processing" type="button"
            class="text-warning-600 hover:text-warning-900" @click="restoreUser(item.id)"
          >
            Restore
            <!-- <heroicons-arrow-path-rounded-square-20-solid class="w-5 h-5" /> -->
            <span class="sr-only">, {{ item.name }}</span>
          </button>
          <div v-if="false" class="flex items-center space-x-2 ">
            <button v-if="item.status === 'active'" :disabled="processing" type="button" class="text-danger-600 hover:text-danger-900" @click="deleteUser(item.id)">
              <heroicons-trash-20-solid class="w-5 h-5" />
              <span class="sr-only">, {{ item.name }}</span>
            </button>

            <!-- restore -->
            <button v-if="item.status === 'deleted'" :disabled="processing" type="button" class="text-warning-600 hover:text-warning-900" @click="restoreUser(item.id)">
              Restore
              <!-- <heroicons-arrow-path-rounded-square-20-solid class="w-5 h-5" /> -->
              <span class="sr-only">, {{ item.name }}</span>
            </button>
          </div>
        </td>
      </template>
    </JTable>
  </section>
</template>
