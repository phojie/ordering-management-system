import HeroiconsHome from '~icons/heroicons/home'
import HeroiconsDocumentDuplicate from '~icons/heroicons/document-duplicate'
import HeroiconsShoppingCart from '~icons/heroicons/shopping-cart'
import HeroiconsBars3 from '~icons/heroicons/bars-3'
import HeroiconsBeaker from '~icons/heroicons/beaker'
import HeroiconsBookmark from '~icons/heroicons/bookmark'
import HeroiconsClipboard from '~icons/heroicons/clipboard'
import HeroiconsUserGroup from '~icons/heroicons/user-group'
import HeroiconsCog from '~icons/heroicons/cog'
import HeroiconsDocumentText from '~icons/heroicons/document-text'
import HeroiconsQuestionMarkCircle from '~icons/heroicons/question-mark-circle'

export const useNavigation = () => {
  const adminItems = [
    {
      name: 'Home',
      icon: HeroiconsHome,
      href: '/admin/',
    },
    {
      name: 'Menus',
      icon: HeroiconsDocumentDuplicate,
      href: '/admin/menus',
    },
    {
      name: 'Orders',
      icon: HeroiconsShoppingCart,
      href: '/admin/orders',
    },
    {
      name: 'Items',
      icon: HeroiconsBars3,
      href: '/admin/items',
    },
    {
      name: 'Add-ons',
      icon: HeroiconsBeaker,
      href: '/admin/add_ons',
    },
    {
      name: 'Item Types',
      icon: HeroiconsBookmark,
      href: '/admin/item_types',
    },
    {
      name: 'Offers',
      icon: HeroiconsClipboard,
      href: '/admin/offers',
    },
  ]

  const miscItems = [
    {
      name: 'Users',
      icon: HeroiconsUserGroup,
      href: '/admin/users',
    },
    {
      name: 'Settings',
      icon: HeroiconsCog,
      href: '/admin/settings',
    },
    {
      name: 'Information',
      icon: HeroiconsDocumentText,
      href: '/admin/pages',
    },
    {
      name: 'Help',
      icon: HeroiconsQuestionMarkCircle,
      href: '/admin/help',
    },
  ]

  return {
    adminItems,
    miscItems,
  }
}
