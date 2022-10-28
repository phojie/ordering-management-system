import { defineStore } from 'pinia'
export const useSidebarStore = defineStore('sidebar', () => {
  // sidebar
  let state = $ref(false)

  // toggle sidebar
  const toggle = () => {
    state = !state
  }

  // close sidebar
  const close = () => {
    state = false
  }

  // open sidebar
  const open = () => {
    state = true
  }

  return {
    state,
    toggle,
    close,
    open,
  }
})
