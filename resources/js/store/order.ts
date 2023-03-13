import { helpers, required } from '@vuelidate/validators'
import type { TableHeader } from '@/j-components/types'
import type { Order } from '@/types/order'

type FormType = 'create' | 'edit'

interface FormState {
  type: FormType
  show: boolean
  title: string
  description: string
}

export const useOrderStore = defineStore('order', () => {
  // processing state
  let processing = $ref<boolean>(false)

  // data form state
  const form = $ref<Order>({
    id: '',
    userId: '',
    user: null,

    // shipping info
    name: '',
    status: '',
    orderNumber: 0,
    email: '',
    phone: '',
    address: '',
    city: '',
    province: '',
    postalCode: '',

    // payment info
    totalAmount: 0,
    taxesAmount: 0,
    shippingAmount: 0,

    // orders
    orderVariants: [],
  })

  // form state
  const formState = $ref<FormState>({
    type: 'create',
    show: false,
    title: 'New Order',
    description: 'Create a new order',
  })

  // table headers
  const headers = $ref<TableHeader[]>([
    {
      text: 'Order number',
      value: 'order_number',
      sortable: true,
      filterable: true,
    },
    {
      text: 'Customer',
      value: 'customer',
      class: 'min-w-[12rem]',
      sortable: true,
      filterable: true,
      filterOptions: {
        type: 'text',
      },
    },
    {
      text: 'Orders',
      value: 'orders',
    },
    {
      text: 'Total',
      value: 'total',
    },
    {
      text: 'Status',
      value: 'status',
      sortable: true,
      filterable: true,
      filterOptions: {
        type: 'text',
      },
    },
    {
      text: 'Date',
      value: 'created_at',
      sortable: true,
    },
    {
      text: '',
      value: 'actions',
      class: '!relative !pl-3 !pr-4 !sm:pr-6',
    },
  ])

  // validate state
  const rules = {
    id: {},
    name: {
      required: helpers.withMessage('Order name is required', required),
      $autoDirty: true,
    },
    status: {
      required: helpers.withMessage('Order status is required', required),
      $autoDirty: true,
    },

    orderNumber: {
      required: helpers.withMessage('Order number is required', required),
      $autoDirty: true,
    },
    email: {
      required: helpers.withMessage('Order email is required', required),
      $autoDirty: true,
    },
    phone: {
      required: helpers.withMessage('Order phone is required', required),
      $autoDirty: true,
    },
    address: {
      required: helpers.withMessage('Order address is required', required),
      $autoDirty: true,
    },
    city: {
      required: helpers.withMessage('Order city is required', required),
      $autoDirty: true,
    },
    province: {
      required: helpers.withMessage('Order province is required', required),
      $autoDirty: true,
    },
    postalCode: {
      required: helpers.withMessage('Order postal code is required', required),
      $autoDirty: true,
    },
    totalAmount: {
      required: helpers.withMessage('Order total amount is required', required),
      $autoDirty: true,
    },
    taxesAmount: {
      required: helpers.withMessage('Order taxes amount is required', required),
      $autoDirty: true,
    },
    shippingAmount: {
      required: helpers.withMessage('Order shipping amount is required', required),
      $autoDirty: true,
    },
  }

  const $externalResults = ref({})
  const $v = useVuelidate(rules as any, form, { $externalResults })

  // submit form
  async function submitForm() {
    if (!await $v.value.$validate())
      return

    if (formState.type === 'create')
      createOrder()

    else
      updateOrder(form.id as string)
  }

  // reload orders
  function reload() {
    Inertia.reload(
      {
        only: ['orders'],
        onBefore: () => {
          processing = true
        },
        onFinish: () => {
          processing = false
        },
        onSuccess: () => {
          useNotificationStore().add({
            id: parseInt(_.uniqueId()),
            title: 'Orders is successfully reloaded',
          })
        },
      },
    )
  }

  // get orders
  async function getOrders(requestData: any) {
    await Inertia.get(route('admin.orders.index'),
      {
        ...route().params,
        ...requestData,
      },
      {
        preserveState: true,
        replace: true,
        only: ['orders'],
        onBefore: () => {
          processing = true
        },
        onFinish: () => {
          processing = false
        },
      },
    )
  }

  // create order
  async function createOrder() {
    Inertia.post(route('admin.orders.store'), form as any, {
      onBefore: () => {
        processing = true
      },
      onFinish: () => {
        processing = false
      },
      onError: (error) => {
        $externalResults.value = error
      },
      onSuccess: () => {
        resetForm()
      },
    })
  }

  // update order
  async function updateOrder(id: string) {
    Inertia.put(route('admin.orders.update', id), form as any, {
      onBefore: () => {
        processing = true
      },
      onFinish: () => {
        processing = false
      },
      onError: (error) => {
        $externalResults.value = error
      },
      onSuccess: () => {
        resetForm()
        resetFormState()
      },
    })
  }

  // delete order
  function deleteOrder(id: string) {
    Inertia.delete(route('admin.orders.destroy', id), {
      onBefore: () => {
        processing = true
      },
      onFinish: () => {
        processing = false
      },
    })
  }

  // delete multiple orders
  function deleteOrders(ids: string[]) {
    Inertia.delete(route('admin.orders.destroy-multiple'), {
      data: {
        ids,
      },
      onBefore: () => {
        processing = true
      },
      onFinish: () => {
        processing = false
      },
    })
  }

  // restore order
  function restoreOrder(id: string) {
    Inertia.put(route('admin.orders.restore', id),
      {
      },
      {
        onBefore: () => {
          processing = true
        },
        onFinish: () => {
          processing = false
        },
      })
  }

  // restore orders
  function restoreOrders(ids: string[]) {
    Inertia.put(route('admin.orders.restore-multiple'),
      {
        ids,
      },
      {
        data: {
          ids,
        },
        onBefore: () => {
          processing = true
        },
        onFinish: () => {
          processing = false
        },
      })
  }

  // reset form
  function resetForm() {
    form.id = ''
    form.status = ''
    form.name = ''
    form.email = ''
    form.phone = ''
    form.address = ''
    form.city = ''
    form.province = ''
    form.postalCode = ''
    form.status = ''

    form.totalAmount = 0
    form.taxesAmount = 0
    form.shippingAmount = 0

    form.userId = ''

    form.orderVariants = []
    form.user = null

    $v.value.$reset()
  }

  // reset form state
  function resetFormState() {
    formState.type = 'create'
    formState.show = false
    formState.title = 'New Order'
    formState.description = 'Create a new order'
  }

  return $$({
    processing,
    headers,
    $v,
    form,
    formState,

    reload,
    getOrders,
    submitForm,
    resetForm,
    deleteOrder,
    deleteOrders,
    restoreOrder,
    restoreOrders,
    resetFormState,
  })
})

// make sure to pass the right store definition, `useOrder` in this case.
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useOrderStore, import.meta.hot))
