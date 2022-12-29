<script setup lang="ts">
import type { PaginationRoles, Role } from '@/types/role'
defineProps<{
  roles: PaginationRoles
}>()

const { formState, form, headers, deleteRoles, restoreRole } = useRoleStore()
const processing = toRef(useRoleStore(), 'processing')
const selected = ref<any>([])

const deleteAll = () => {
  deleteRoles(selected.value)
  selected.value = []
}

const toggleEdit = (role: Role) => {
  form.id = role.id
  form.name = role.name
  form.description = role.description
  form.permissions = role.permissions

  formState.type = 'edit'
  formState.show = true
  formState.title = 'Edit Role'
  formState.description = `Edit the details for ${role.name}`
}

const getById = async (id: number) => {
  await useFetch(route('components.roles.show', id)).get().json().then(({ data }) => {
    toggleEdit(data.value)
  })
}
</script>

<template>
  <section class="flex flex-col px-4 space-y-6 sm:px-6 lg:px-8">
    <JTable
      v-model="selected"
      empty-data-text="No roles found."
      :indeterminate="true"
      :items="roles?.data ?? []"
      item-key="id"
      :headers="headers"
      :is-loading="processing"
      :links="roles?.meta?.links ?? []"
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

        <td class="px-3 py-4 text-sm text-gray-500 whitespace-normal">
          {{ item.permissionsCount }}
        </td>

        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          <JBadge
            :label="item.status === 'deleted' ? 'Deleted' : item.status"
            :variant="item.status === 'active' ? 'success' : 'danger'"
            :class="item.status === 'active' ? '!font-semibold' : ''"
          />
        </td>
        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
          {{ useDateFormat(item.createdAt, 'MMM DD, YYYY').value }}
        </td>

        <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
          <button
            v-if="item.status === 'active' && useGate().can('role-update')"
            v-tooltip="'Edit role'"
            type="button"
            class="text-primary-600 hover:text-primary-900" @click="getById(item.id)"
          >
            <heroicons-pencil-square-20-solid class="w-5 h-5" />
          </button>

          <button
            v-else-if="item.status === 'deleted' && useGate().can('role-delete')"
            v-tooltip="'Restore role'"
            type="button"
            class="text-warning-600 hover:text-warning-900"
            @click="restoreRole(item.id)"
          >
            <heroicons-arrow-path-rounded-square-20-solid class="w-5 h-5" />
          </button>
        </td>
      </template>
    </JTable>
  </section>
</template>
