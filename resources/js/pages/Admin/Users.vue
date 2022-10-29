<script setup lang="ts">
import type { User } from '@/types/user'
import AdminLayout from '@/layouts/AdminLayout.vue'

const props = defineProps<{
  users?: User[]
}>()

defineOptions({
  layout: AdminLayout,
})
</script>

<template>
  <Head>
    <title>Users</title>
  </Head>

  <div>
    <ul>
      <li v-for="user in props.users" :key="user.id">
        {{ user.username }}
      </li>
    </ul>
  </div>
</template>
