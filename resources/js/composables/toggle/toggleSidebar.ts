import { acceptHMRUpdate, defineStore } from 'pinia'
export const useToggleSidebar = defineStore('toggleSidebar', () => {
  // sidebar
  const state = ref(false)

  // toggle sidebar
  const toggle = () => {
    state.value = !state
  }

  // close sidebar
  const close = () => {
    state.value = false
  }

  // open sidebar
  const open = () => {
    state.value = true
  }

  return {
    state,
    toggle,
    close,
    open,
  }
})

if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useToggleSidebar, import.meta.hot))
