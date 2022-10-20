export const useNavigation = () => {
    const adminItems = ref([
        {
            name: 'Home',
            icon: 'heroicons:home',
            to: '/admin/',
        },
        {
            name: 'Menus',
            icon: 'heroicons:document-duplicate',
            to: '/admin/menus',
        },
        {
            name: 'Orders',
            icon: 'heroicons:shopping-cart',
            to: '/admin/orders',
        },
        {
            name: 'Items',
            icon: 'heroicons:bars-3',
            to: '/admin/items',
        },
        {
            name: 'Add-ons',
            icon: 'heroicons:beaker',
            to: '/admin/add_ons',
        },
        {
            name: 'Item Types',
            icon: 'heroicons:bookmark',
            to: '/admin/item_types',
        },
        {
            name: 'Offers',
            icon: 'heroicons:clipboard',
            to: '/admin/offers',
        },
    ])

    const miscItems = ref([
        {
            name: 'Users',
            icon: 'heroicons:user-group',
            to: '/admin/users',
        },
        {
            name: 'Settings',
            icon: 'heroicons:cog',
            to: '/admin/settings',
        },
        {
            name: 'Information',
            icon: 'heroicons:document-text',
            to: '/admin/pages',
        },
        {
            name: 'Help',
            icon: 'heroicons:question-mark-circle',
            to: '/admin/help',
        },
    ])

    return {
        adminItems,
        miscItems,
    }
}
