import type { Notification } from '@/global'

export const useNotificationStore = defineStore('notification', () => {
  const notifications = reactive<Array<Notification>>([
    // {
    //   id: 1,
    //   title: 'Discussion moved 1',
    //   message: 'Lorem ipsum dolor sit amet consectetur adipisicing elit oluptatum tenetur.',
    //   type: 'success',
    //   showClose: true,
    //   showIcon: true,
    //   position: 'top-right',
    // },
    // {
    //   id: 2,
    //   title: 'Discussion moved 2',
    //   message: 'Lorem ipsum dolor sit amet consectetur adipisicing elit oluptatum tenetur.',
    //   type: 'error',
    //   showClose: false,
    //   showIcon: true,
    //   position: 'top-right',
    // },
    // {
    //   id: 3,
    //   title: 'Discussion moved 3',
    //   message: 'Lorem ipsum dolor sit amet consectetur adipisicing elit oluptatum tenetur.',
    //   type: 'warning',
    //   duration: 5000,
    //   showClose: true,
    //   showIcon: true,
    //   position: 'top-right',
    // },
  ])

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

