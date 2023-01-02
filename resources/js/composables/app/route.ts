export const useRoute = () => {
  const currentRoute = route().current() as string // ('admin.index')
  const currentUrl = usePage().url.value // ('/admin/')
  const breadCrumb = $computed(() => {
    // get the crumbs using currentUrl
    const crumbs = currentUrl.split('/').filter(crumb => crumb !== '')
    const breadCrumb = crumbs.map((crumb, index) => {
      const href = `/${crumbs.slice(0, index + 1).join('/')}/`
      const name = crumb
      const exact = index === crumbs.length - 1
      return {
        href,
        name,
        exact,
      }
    })

    return breadCrumb
  })

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
    breadCrumb,

    currentRoute,
    currentUrl,
  }
}

