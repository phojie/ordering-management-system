export const useRoute = () => {
  function isActive(href: string, exact = false) {
    const currentUrl = usePage().url.value
    if (exact)
      return currentUrl.startsWith(href)

    return _.trim(href, '/') === _.trim(currentUrl, '/')
  }

  const currentRoute = route().current() as string

  return {
    isActive,

    currentRoute,
  }
}

