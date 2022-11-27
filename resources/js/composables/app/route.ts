export const useRoute = () => {
  const currentRoute = route().current() as string
  const currentUrl = usePage().url.value

  function isActive(href: string, exact = false) {
    // const currentUrl = usePage().url.value
    if (exact)
      return _.startsWith(currentUrl, href)

    return _.trim(href, '/') === _.trim(currentUrl, '/')
  }

  const defaultSearch = _.get(route().params, 'search', '') as string
  const defaultRows = _.get(route().params, 'rows', '10') as string
  return {
    isActive,
    defaultRows,
    defaultSearch,

    currentRoute,
    currentUrl,
  }
}

