import type { Notification } from '@/global'

export const useNotificationStore = defineStore('notification', () => {
  const pageProps = computed<any>(() => usePage().props.value)
  const flash = computed<Notification>(() => pageProps.value.flash.message)

  // watch flash
  watch(() => flash.value, (value) => {
    if (value) {
      const notification: Notification = {
        ...value,
        id: parseInt(_uniqueId()),
      }
      add(notification)
    }
  })

  const notifications = reactive<Array<Notification>>([])

  // add notification
  function add(notification: Notification) {
    notifications.push(notification)
  }

  function remove(id: number) {
    const index = notifications.findIndex(notification => notification.id === id)
    notifications.splice(index, 1)
  }

  return {
    notifications,
    add,
    remove,
  }
})

if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useNotificationStore, import.meta.hot))

