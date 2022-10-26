export const useSlideOver = () => {
  // loader
  const state = ref<boolean>(false)

  // show slide-over
  function show() {
    state.value = true
  }

  // hide slide-over
  function hide() {
    state.value = false
  }

  return { state, show, hide }
}
