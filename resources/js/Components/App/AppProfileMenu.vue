<script setup lang="ts">
import { Menu, MenuButton, MenuItems } from '@headlessui/vue'

const { user } = useUser()
</script>

<template>
  <Menu v-if="user" as="div" class="relative ml-3">
    <div>
      <MenuButton
        class="flex items-center max-w-xs text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 lg:rounded-md lg:p-2 lg:hover:bg-gray-50"
      >
        <img class="w-8 h-8 rounded-full" :src="`https://robohash.org/${user.id}?set=set3&bgset=bg2&size=400x400`" alt="Profile">
        <span class="hidden ml-3 text-sm font-medium text-gray-700 lg:block"><span class="sr-only">Open user
          menu for </span>{{ user?.username }}</span>
        <heroicons-chevron-down-20-solid
          class="flex-shrink-0 hidden w-5 h-5 ml-1 text-gray-400 lg:block" aria-hidden="true"
        />
      </MenuButton>
    </div>
    <transition
      enter-active-class="transition duration-100 ease-out"
      enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
      leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100"
      leave-to-class="transform scale-95 opacity-0"
    >
      <MenuItems
        class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
      >
        <AppProfileMenuItems />
      </MenuItems>
    </transition>
  </Menu>
</template>
