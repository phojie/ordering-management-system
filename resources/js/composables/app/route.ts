export const useRoute = () => {
  function isActive(href: string, exact = false) {
    const currentUrl = usePage().url.value
    if (exact)
      return currentUrl.startsWith(href)

    return _.trim(href, '/') === _.trim(currentUrl, '/')
  }

  return {
    isActive,
  }
}

