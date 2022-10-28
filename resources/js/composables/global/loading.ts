export const useLoading = () => {
  // loader
  let state = $ref(false)

  // show loader
  function show() {
    state = true
  }

  // hide loader
  function hide() {
    state = false
  }

  return { state, show, hide }
}
