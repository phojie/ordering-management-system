<script setup lang="ts">
</script>

<template>
  <div class="h-screen ">
    <AdminSideBar />
    <div class="flex flex-col h-full pb-24 overflow-auto bg-gray-100 lg:pl-64">
      <AdminHeader />
      <slot />
    </div>

    <!-- notifications -->
    <AppNotification />
  </div>
</template>
