<script setup lang="ts">
import type { PaginationLink } from '@/types/constants'
import type { User } from '@/types/user'

interface PaginationProps {
  data: User[]
  currentPage: number
  lastPage: number
  links: Array<PaginationLink>
  nextPageUrl: string
  prevPageUrl: string
}

defineProps<{
  users: PaginationProps
}>()

defineOptions({
  layout: AdminLayout,
})

const { state, show, hide } = useSlideOver()

const closeSlideOver = () => {
  useMenuStore().resetForm()
  hide()
}

const user = useUser()
</script>

<template>
  <div>
    <Head title="Users | Admin" />

    <main class="flex-1">
      <!-- Page title & actions -->
      <div class="px-4 py-6 bg-white border-b border-gray-200 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="flex-1 min-w-0">
          <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">
              Users
            </h1>
            <p class="mt-2 text-sm text-gray-700">
              Manage your users
            </p>
          </div>
        </div>
        <div class="flex mt-4 sm:mt-0 sm:ml-4">
          <!-- search area -->
          <button
            type="button"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary-600 order-0 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:order-1 sm:ml-3"
            @click="show"
          >
            Create
          </button>

          <button
            type="button"
            :disabled="user.processing"
            class="inline-flex items-center p-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary-600 order-0 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:order-1 sm:ml-3"
            @click="user.reload()"
          >
            <zondicons-reload
              class="w-5 h-5 "
            />
          </button>
        </div>
      </div>

      <!-- Table -->
      <section class="flex flex-col px-4 mt-8 space-y-6 sm:px-6 lg:px-8">
        <JTable
          :items="users?.data ?? []"
          item-key="id"
          :headers="user.headers"
        >
          <template
            #table-data="{ item, selected }"
          >
            <td
              class="py-4 pr-3 text-sm font-medium whitespace-nowrap"
              :class="[selected ? 'text-primary-600' : 'text-gray-900']"
            >
              {{ item.username }}
            </td>
            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
              {{ item.email }}
            </td>
            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
              {{ item.created_at }}
            </td>
            <td class="py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
              <a href="#" class="text-primary-600 hover:text-primary-900">Edit<span class="sr-only">,
                {{ item.name }}</span></a>
            </td>
          </template>
        </JTable>
        <JPagination :links="users.links" />
      </section>

      <!-- Slide over -->
      <AdminUsersSlideOver :state="state" @hide="closeSlideOver" />
    </main>
  </div>
</template>
