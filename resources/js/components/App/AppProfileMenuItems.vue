<script setup lang="ts">
import { MenuItem, MenuItems } from '@headlessui/vue'

const auth = useAuthStore()
</script>

<template>
  <MenuItems
    class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
  >
    <div class="py-1">
      <!-- <MenuItem v-slot="{ active }">
        <AppProfileMenuItem :is-active="active" href="#">
          View Profile
        </AppProfileMenuItem>
      </MenuItem> -->
      <MenuItem v-slot="{ active }">
        <AppProfileMenuItem :is-active="active" :href="route('admin.settings.index')">
          Settings
        </AppProfileMenuItem>
      </MenuItem>
    </div>
    <!-- <div class="py-1">
      <MenuItem v-slot="{ active }">
        <AppProfileMenuItem :is-active="active" href="#">
          Get Desktop App
        </AppProfileMenuItem>
      </MenuItem>
      <MenuItem v-slot="{ active }">
        <AppProfileMenuItem :is-active="active" href="#">
          Information
        </AppProfileMenuItem>
      </MenuItem>
    </div> -->
    <div class="py-1">
      <MenuItem v-slot="{ active }">
        <AppProfileMenuItem :is-active="active" @click="auth.signOut()">
          Logout
        </AppProfileMenuItem>
      </MenuItem>
    </div>
  </MenuItems>
</template>

