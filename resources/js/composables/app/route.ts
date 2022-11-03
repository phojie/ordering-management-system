export const useRoute = () => {
  function isActive(href: string) {
    const currentUrl = usePage().url.value
    return _trim(href, '/') === _trim(currentUrl, '/')
  }

  return {
    isActive,
  }
}

