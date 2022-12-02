<script setup lang="ts">
const auth = useAuthStore()
</script>

<template>
  <Menu v-if="auth.signedIn" as="div" class="relative ml-3">
    <div>
      <MenuButton
        class="flex items-center max-w-xs text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 lg:rounded-md lg:p-2 lg:hover:bg-gray-50"
      >
        <img class="w-8 h-8 rounded-full" :src="auth.user?.avatar" alt="Profile">
        <span class="hidden ml-3 text-sm font-medium text-gray-700 lg:block"><span class="sr-only">Open auth
          menu for </span>{{ auth.user?.fullName }}</span>
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
      <AppProfileMenuItems />
    </transition>
  </Menu>
</template>
