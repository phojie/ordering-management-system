export const useSlideOver = () => {
  // loader
  let state = $ref<boolean>(false)

  // show slide-over
  function show() {
    state = true
  }

  // hide slide-over
  function hide() {
    state = false
  }

  return { state, show, hide }
}
