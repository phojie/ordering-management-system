<script setup lang="ts">
const { notifications, remove } = useNotificationStore()
</script>

<template>
  <div aria-live="assertive" class="fixed inset-0 flex z-[1000] items-end px-4 py-6 pointer-events-none sm:items-start sm:p-6">
    <div class="flex flex-col items-center w-full space-y-4 sm:items-end">
      <JNotification
        v-for="notification in notifications"
        :id="notification.id"
        :key="notification.id"
        :notification="notification"
        :title="notification.title"
        :variant="notification.variant"
        :message="notification.message"
        :icon="notification.icon"
        :duration="notification.duration"
        :show-icon="notification.showIcon"
        :actions="notification.actions"
        :show-close="notification.showClose"
        :position="notification.position"
        @close="remove(notification.id)"
      />
    </div>
  </div>
</template>

