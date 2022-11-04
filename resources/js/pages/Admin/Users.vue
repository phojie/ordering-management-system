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

let selected = $ref([] as any[])
const deleteAll = () => {
  user.deleteUsers(selected)
  selected = []
}
</script>

<template>
  <div>
    <Head title="Users | Admin" />

    <main class="flex-1">
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
            @click="show"
          >
            Add user
          </button>
        </div>
      </div>

      <!-- Table -->
      <section class="flex flex-col px-4 mt-2 space-y-6 sm:px-6 lg:px-8">
        <JTable
          v-model="selected"
          :indeterminate="true"
          :items="users?.data ?? []"
          item-key="id"
          :headers="user.headers"
          :is-loading="user.processing"
          :links="users?.links ?? []"
          @deleteAll="deleteAll()"
        >
          <template
            #table-data="{ item, selected }"
          >
            <td class="py-4 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-6">
              <div class="flex items-center">
                <div class="flex-shrink-0 w-10 h-10">
                  <img
                    class="w-10 h-10 rounded-full" :src="`https://robohash.org/${item?.id}?set=set3&bgset=bg2&size=400x400`"
                    alt="Profile"
                  >
                </div>
                <div class="ml-4">
                  <div
                    class="font-medium"
                    :class="[selected ? 'text-primary-600' : 'text-gray-900']"
                  >
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
              <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">Active</span>
            </td>
            <td class="py-4 text-sm font-medium whitespace-nowrap">
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

      <!-- Slide over -->
      <AdminUsersSlideOver :state="state" @hide="closeSlideOver" />
    </main>
  </div>
</template>
