export const useRoute = () => {
  const currentRoute = route().current() as string // ('admin.index')
  const currentUrl = usePage().url.value // ('/admin/')

  function isActive(href: string, exact = false): boolean {
    if (exact)
      // TODO: Fix this, return false if has query params
      return currentRoute === href

    return currentRoute === href
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

