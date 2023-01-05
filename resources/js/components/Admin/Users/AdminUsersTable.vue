<script setup lang="ts">
import type { PaginationUsers, User } from '@/types/user'
defineProps<{
  users: PaginationUsers
}>()

const { formState, form, headers, deleteUsers, restoreUser } = useUserStore()
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
  form.roles = user.roles
  form.email = user.email
  form.avatar = user.avatar
  form.password = 'password'

  formState.type = 'edit'
  formState.show = true
  formState.title = 'Edit User'
  formState.description = `Edit the details for ${user.fullName}`
}

const getById = async (id: number) => {
  await useFetch(route('components.users.show', id)).get().json().then(({ data }) => {
    toggleEdit(data.value)
  })
}
</script>

<template>
  <section class="flex flex-col px-4 space-y-6 sm:px-6 lg:px-8">
    <JTable
      v-model="selected"
      empty-data-text="No users found."
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
                class="w-10 h-10 rounded-full"
                :src="item.avatar"
                loading="lazy"
                alt="…"
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
          {{ item.username }}
        </td>
        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          <JBadge
            :label="item.status === 'deleted' ? 'Suspended' : item.status"
            :variant="item.status === 'active' ? 'success' : 'danger'"
            :class="item.status === 'active' ? '!font-semibold' : ''"
          />
        </td>
        <td class="gap-2 px-3 py-4 text-sm whitespace-nowrap">
          <span class="inline-flex gap-2">
            <JBadge
              v-for="role in item.roles"
              :key="role.id"
            >
              <span
                :style="`background-color:${role.color}`"
                :class="{ 'bg-gray-400': !role.color }"
                class="w-2 h-2 mr-2 rounded-full "
              />
              <span class="font-medium capitalize">
                {{ role.name }}
              </span>
            </JBadge>
          </span>
        </td>
        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          {{ useDateFormat(item.createdAt, 'MMM DD, YYYY').value }}
        </td>
        <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
          <button
            v-if="item.status === 'active' && useGate().can('user-update')"
            v-tooltip="'Edit user'"
            type="button"
            class="text-primary-600 hover:text-primary-900" @click="getById(item.id)"
          >
            <heroicons-pencil-square-20-solid class="w-5 h-5" />
          </button>

          <button
            v-else-if="item.status === 'deleted' && useGate().can('user-delete')"
            v-tooltip="'Restore user'"
            type="button"
            class="text-warning-600 hover:text-warning-900"
            @click="restoreUser(item.id)"
          >
            <heroicons-arrow-path-rounded-square-20-solid class="w-5 h-5" />
          </button>
        </td>
      </template>
    </JTable>
  </section>
</template>
