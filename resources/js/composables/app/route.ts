export const useRoute = () => {
  function isActive(href: string, exact = false) {
    const currentUrl = usePage().url.value
    if (exact)
      return currentUrl.startsWith(href)

    return _.trim(href, '/') === _.trim(currentUrl, '/')
  }

  const currentRoute = route().current() as string

  const defaultSearch = _.get(route().params, 'search', '') as string
  const defaultRows = _.get(route().params, 'rows', '10') as string
  return {
    isActive,
    defaultRows,
    defaultSearch,

    currentRoute,
  }
}

