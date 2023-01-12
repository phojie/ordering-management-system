<script setup lang="ts">
onMounted(() => {
  if (useAuthStore().signedIn) {
    window.Echo.channel(`orders.${useAuthStore().user.id}`)
      .listen('.order.status.updated', (e: any) => {
        useNotificationStore().add({
          id: parseInt(_.uniqueId()),
          title: 'Order Status Updated',
          message: `Order #${e.order.orderNumber} status updated to ${e.order.status}`,
          variant: 'success',
          icon: 'check',
        })
      })
  }
})

onUnmounted(() => {
  if (useAuthStore().signedIn)
    window.Echo.leave(`orders.${useAuthStore().user.id}`)
})
</script>

<template>
  <div class="bg-white">
    <Head title="Ronalds Catering" />

    <AppHeader />

    <slot />

    <AppFooter />

    <AppNotification />
  </div>
</template>
