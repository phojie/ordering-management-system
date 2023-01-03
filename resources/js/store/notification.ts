import type { Notification } from '@/j-components/types'

export const useNotificationStore = defineStore('notification', () => {
  const pageProps = computed<any>(() => usePage().props.value)
  const flashNotification = computed<Notification>(() => pageProps.value.flash.notification)

  // watch flash
  watch(() => flashNotification.value, (value) => {
    if (value) {
      const notification: Notification = {
        ...value,
        id: parseInt(_.uniqueId()),
      }
      add(notification)
    }
  })

  const notifications = $ref<Array<Notification>>([
    // {
    //   id: 1,
    //   variant: 'danger',
    //   icon: 'trash',
    //   title: 'This is a success notification',
    //   message: 'This is a success message',
    // },
    // {
    //   id: 2,
    //   variant: 'danger',
    //   icon: 'warning',
    //   title: 'This is a success notification',
    //   message: 'This is a success message',
    // },
    // {
    //   id: 3,
    //   variant: 'success',
    //   icon: 'check',
    //   title: 'This is a success notification',
    //   message: 'This is a success message',
    // },
  ])

  // add notification
  function add(notification: Notification) {
    notifications.unshift(notification)
  }

  function remove(id: number) {
    const index = notifications.findIndex(notification => notification.id === id)
    notifications.splice(index, 1)
  }

  return $$({
    notifications,
    add,
    remove,
    pageProps,
  })
})

if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useNotificationStore, import.meta.hot))

