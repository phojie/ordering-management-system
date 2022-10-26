export const useLoading = () => {
  // loader
  const state = ref(false)

  // show loader
  function show() {
    state.value = true
  }

  // hide loader
  function hide() {
    state.value = false
  }

  return { state, show, hide }
}
