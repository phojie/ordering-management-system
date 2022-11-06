<script setup lang="ts">
</script>

<template>
  <JSlideOver title="New User" description="Create a new user" @submit="useUserStore().submitForm()">
    <div class="flex flex-col justify-between flex-1">
      <div class="px-4 divide-y divide-gray-200 sm:px-6">
        <FormUser />
      </div>
    </div>
  </JSlideOver>
</template>
