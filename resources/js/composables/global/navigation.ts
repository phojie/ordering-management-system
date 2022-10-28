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
  const adminItems = $ref([
    {
      name: 'Home',
      icon: HeroiconsHome,
      to: '/admin/',
    },
    {
      name: 'Menus',
      icon: HeroiconsDocumentDuplicate,
      to: '/admin/menus',
    },
    {
      name: 'Orders',
      icon: HeroiconsShoppingCart,
      to: '/admin/orders',
    },
    {
      name: 'Items',
      icon: HeroiconsBars3,
      to: '/admin/items',
    },
    {
      name: 'Add-ons',
      icon: HeroiconsBeaker,
      to: '/admin/add_ons',
    },
    {
      name: 'Item Types',
      icon: HeroiconsBookmark,
      to: '/admin/item_types',
    },
    {
      name: 'Offers',
      icon: HeroiconsClipboard,
      to: '/admin/offers',
    },
  ])

  const miscItems = $ref([
    {
      name: 'Users',
      icon: HeroiconsUserGroup,
      to: '/admin/users',
    },
    {
      name: 'Settings',
      icon: HeroiconsCog,
      to: '/admin/settings',
    },
    {
      name: 'Information',
      icon: HeroiconsDocumentText,
      to: '/admin/pages',
    },
    {
      name: 'Help',
      icon: HeroiconsQuestionMarkCircle,
      to: '/admin/help',
    },
  ])

  return {
    adminItems,
    miscItems,
  }
}
