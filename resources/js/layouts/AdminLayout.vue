<script setup lang="ts">
onMounted(() => {
  if (useAuthStore().signedIn) {
    window.Echo.channel('new-order')
      .listen('.new.order', (e: any) => {
        useNotificationStore().add({
          id: parseInt(_.uniqueId()),
          title: `${e.order.user.fullName} placed a new order`,
          message: `Order #${e.order.orderNumber} has been created`,
          variant: 'success',
          icon: 'check',
        })
      })
  }
})

onUnmounted(() => {
  if (useAuthStore().signedIn)
    window.Echo.leave('new-order')
})
</script>

<template>
  <div class="h-screen">
    <AdminSideBar />
    <div class="flex flex-col h-full pb-24 overflow-auto bg-gray-100 lg:pl-64">
      <AdminHeader />
      <slot />
    </div>

    <!-- notifications -->
    <AppNotification />
  </div>
</template>
