import HeroiconsHome from '~icons/heroicons/home'
// import HeroiconsDocumentDuplicate from '~icons/heroicons/document-duplicate'
import HeroiconsShoppingCart from '~icons/heroicons/shopping-cart'
import HeroiconsBeaker from '~icons/heroicons/beaker'
// import HeroiconsBars3 from '~icons/heroicons/bars-3'
// import HeroiconsBookmark from '~icons/heroicons/bookmark'
// import HeroiconsClipboard from '~icons/heroicons/clipboard'
import HeroiconsUserGroup from '~icons/heroicons/user-group'
import HeroiconsCog from '~icons/heroicons/cog'
import HeroiconsDocumentText from '~icons/heroicons/document-text'
import HeroiconsQuestionMarkCircle from '~icons/heroicons/question-mark-circle'
import HeroiconsFingerPrint from '~icons/heroicons/finger-print'
import HeroiconsQueueList from '~icons/heroicons/queue-list'
// import HeroiconsShieldCheck from '~icons/heroicons/shield-check'

interface NavigationItem {
  name: string
  href: string
  icon: any
  exact?: boolean
  permission?: string
}

export const useNavigation = () => {
  const adminItems: NavigationItem[] = [
    {
      name: 'Home',
      href: 'admin.index',
      icon: HeroiconsHome,
    },
    {
      name: 'Categories',
      href: 'admin.categories.index',
      permission: 'category-list',
      icon: HeroiconsQueueList,
      exact: true,
    },
    {
      name: 'Products',
      icon: HeroiconsBeaker,
      href: 'admin.products.index',
      permission: 'product-list',
      exact: true,
    },
    // {
    //   name: 'Menus',
    //   icon: HeroiconsDocumentDuplicate,
    //   href: '#',
    // },
    {
      name: 'Orders',
      icon: HeroiconsShoppingCart,
      permission: 'order-list',
      href: 'admin.orders.index',
    },
    // {
    //   name: 'Add-ons',
    //   icon: HeroiconsBars3,
    //   href: '#',
    // },
    // {
    //   name: 'Item Types',
    //   icon: HeroiconsBookmark,
    //   href: '#',
    // },
    // {
    //   name: 'Offers',
    //   icon: HeroiconsClipboard,
    //   href: '#',
    // },
  ]

  const miscItems: NavigationItem[] = [
    {
      name: 'Users',
      icon: HeroiconsUserGroup,
      href: 'admin.users.index',
      permission: 'user-list',
      exact: true,
    },
    {
      name: 'Roles',
      icon: HeroiconsFingerPrint,
      href: 'admin.roles.index',
      permission: 'role-list',
      exact: true,
    },
    // {
    //   name: 'Permissions',
    //   icon: HeroiconsShieldCheck,
    //   href: '/permissions',
    // },
    {
      name: 'Settings',
      icon: HeroiconsCog,
      href: 'admin.settings.index',
    },
    {
      name: 'Information',
      icon: HeroiconsDocumentText,
      href: '#',
    },
    {
      name: 'Help',
      icon: HeroiconsQuestionMarkCircle,
      href: '#',
    },
  ]

  const adminItemsGuarded = computed(() => {
    return adminItems.filter((product) => {
      if (product.permission)
        return useGate().can(product.permission)

      return true
    })
  })

  const miscItemsGuarded = computed(() => {
    return miscItems.filter((product) => {
      if (product.permission)
        return useGate().can(product.permission)

      return true
    })
  })

  return {
    adminItemsGuarded,
    miscItemsGuarded,
  }
}
