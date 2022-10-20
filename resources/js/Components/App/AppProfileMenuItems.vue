<script setup lang="ts">
import { MenuItem } from '@headlessui/vue'

const { signOut } = useUser()
</script>

<template>
  <div class="py-1">
    <MenuItem v-slot="{ active }">
      <AppProfileMenuItem to="#" :is-active="active">
        View Profile
      </AppProfileMenuItem>
    </MenuItem>
    <MenuItem v-slot="{ active }">
      <AppProfileMenuItem :is-active="active" to="#">
        Settings
      </AppProfileMenuItem>
    </MenuItem>
  </div>
  <div class="py-1">
    <MenuItem v-slot="{ active }">
      <AppProfileMenuItem :is-active="active" to="#">
        Get Desktop App
      </AppProfileMenuItem>
    </MenuItem>
    <MenuItem v-slot="{ active }">
      <AppProfileMenuItem :is-active="active" to="#">
        Information
      </AppProfileMenuItem>
    </MenuItem>
  </div>
  <div class="py-1">
    <MenuItem v-slot="{ active }">
      <AppProfileMenuItem :is-active="active" @click="signOut()">
        Logout
      </AppProfileMenuItem>
    </MenuItem>
  </div>
</template>

