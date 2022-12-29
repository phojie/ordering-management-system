<script setup lang="ts">
import type { PaginationRoles } from '@/types/role'
defineProps<{
  roles: PaginationRoles
}>()

defineOptions({
  layout: AdminLayout,
})

const { formState, getRoles, reload } = useRoleStore()
const processing = toRef(useRoleStore(), 'processing')

const search = ref<string>(useRoute().defaultSearch)
const rows = ref<string>(useRoute().defaultRows)

watch(search, _.debounce((value) => {
  getRoles({ search: value })
}, 500))

watch(rows, (value) => {
  getRoles({ rows: value })
})

const toggleCreate = () => {
  formState.show = true
}
</script>

<template>
  <main class="flex-1 ">
    <Head title="Roles | Admin" />

    <!-- Page title & actions -->
    <div class="px-4 py-6 border-gray-200 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
      <div class="flex-1 min-w-0">
        <div class="sm:flex-auto">
          <h1 class="text-xl font-semibold text-gray-900">
            Roles
          </h1>
          <p class="mt-2 text-sm text-gray-700">
            A list of all the roles in the system including their name and description.
          </p>
        </div>
      </div>
      <div class="flex justify-between gap-4 mt-4 sm:justify-start sm:mt-0 sm:ml-4">
        <button
          v-if="useGate().can('role-create')"
          type="button" :disabled="processing"
          class="inline-flex items-center p-2 text-sm font-medium text-gray-600 bg-transparent border border-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 "
          @click="reload()"
        >
          <zondicons-reload class="w-5 h-5 " />
        </button>

        <button
          type="button"
          class="inline-flex items-center order-first px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm sm:order-last bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
          @click="toggleCreate"
        >
          Add role
        </button>
      </div>
    </div>

    <div class="grid items-end grid-cols-1 gap-5 px-4 mb-4 sm:grid-cols-12 sm:px-6 lg:px-8">
      <!-- results summary area -->
      <div class="order-last col-span-12 sm:col-span-7 sm:order-first">
        <p class="text-sm text-gray-700">
          Showing
          <span class="font-medium">{{ roles.meta.from }}</span>
          to
          <span class="font-medium">{{ roles.meta.to }}</span>
          of
          <span class="font-medium">{{ roles.meta.total }}</span>
          {{ roles.meta.total > 0 ? 'results' : 'result' }}
        </p>
      </div>

      <!-- Query area -->
      <div
        class="flex col-span-12 gap-2 sm:col-span-5"
      >
        <InputSearch
          v-model="search"
          class="flex-1"
          :processing="processing"
          placeholder="Search by name and description"
        />

        <InputRow
          v-model="rows"
          class="w-20"
          :processing="processing"
        />
      </div>
    </div>

    <!-- Table -->
    <AdminRolesTable :roles="roles" />

    <!-- Slide over -->
    <AdminRolesSlideOver :state="formState.show" />
  </main>
</template>
