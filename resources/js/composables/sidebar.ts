import { defineStore } from 'pinia'
export const useSidebarStore = defineStore('sidebar', () => {
    // sidebar
    const state = ref(false)

    // toggle sidebar
    const toggle = () => {
        state.value = !state.value
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
