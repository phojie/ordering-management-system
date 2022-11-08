<script setup lang="ts">
import type { PaginationUsers } from '@/types/user'
defineProps<{
  users: PaginationUsers
}>()

defineOptions({
  layout: AdminLayout,
})

const user = useUserStore()
const formState = useUserStore().formState

const toggleCreate = () => {
  formState.show = true
}
</script>

<template>
  <Head title="Users | Admin" />

  <main class="flex-1 ">
    <!-- Page title & actions -->
    <div class="px-4 py-6 border-gray-200 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
      <div class="flex-1 min-w-0">
        <div class="sm:flex-auto">
          <h1 class="text-xl font-semibold text-gray-900">
            Users
          </h1>
          <p class="mt-2 text-sm text-gray-700">
            A list of all the users in your account including their name, title, email and role.
          </p>
        </div>
      </div>
      <div class="flex justify-between gap-4 mt-4 sm:justify-start sm:mt-0 sm:ml-4">
        <!-- search area -->

        <button
          type="button" :disabled="user.processing"
          class="inline-flex items-center p-2 text-sm font-medium text-gray-600 bg-transparent border border-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 "
          @click="user.reload()"
        >
          <zondicons-reload class="w-5 h-5 " />
        </button>

        <button
          type="button"
          class="inline-flex items-center order-first px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm sm:order-last bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
          @click="toggleCreate"
        >
          Add user
        </button>
      </div>
    </div>

    <!-- Table -->
    <AdminUsersTable :users="users" />

    <!-- Slide over -->
    <AdminUsersSlideOver :state="formState.show" />
  </main>
</template>
