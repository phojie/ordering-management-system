// import type { Header } from '@/j-components/types'
export const useUser = defineStore('user', () => {
  const headers = ref([
    { text: 'Username', value: 'username' },
    { text: 'Email', value: 'email' },
    { text: 'Role', value: 'role' },
    { text: 'Actions', value: 'actions', sortable: false },
  ])

  const processing = ref<boolean>(false)

  function reload() {
    Inertia.reload(
      {
        only: ['users'],
        onBefore: () => {
          processing.value = true
        },
        onFinish: () => {
          processing.value = false
        },
      },
    )
  }

  return {
    processing,
    headers,

    reload,
  }
})

// make sure to pass the right store definition, `useAuth` in this case.
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useUser, import.meta.hot))

