// import type { Header } from '@/j-components/types'
export const useUser = defineStore('user', () => {
  const headers = ref([
    {
      text: 'Username',
      value: 'username',
      class: 'min-w-[12rem] py-3.5 pr-3 text-left text-sm font-semibold text-gray-900',
    },
    {
      text: 'Title',
      value: 'title',
      class: 'px-3 py-3.5 text-left text-sm font-semibold text-gray-900',
    },
    {
      text: 'Role',
      value: 'role',
      class: 'px-3 py-3.5 text-left text-sm font-semibold text-gray-900',
    },
    {
      text: '',
      value: 'actions',
      class: 'relative py-3.5 pl-3 pr-4 sm:pr-6',
      sortable: false,
    },
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

