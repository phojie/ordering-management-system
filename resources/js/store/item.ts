import { helpers, maxLength, required } from '@vuelidate/validators'
import type { TableHeader } from './../j-components/types'
import type { Item } from '@/types/item'

type FormType = 'create' | 'edit'

interface FormState {
  type: FormType
  show: boolean
  title: string
  description: string
}

export const useItemStore = defineStore('item', () => {
  // processing state
  let processing = $ref<boolean>(false)

  // data form state
  const form = $ref<Item>({
    id: '',
    status: 'active',
    name: '',
    description: '',
    image: '',

    variants: [],
    categories: [],
  })

  // form state
  const formState = $ref<FormState>({
    type: 'create',
    show: false,
    title: 'New Item',
    description: 'Create a new item',
  })

  // table headers
  const headers = $ref<TableHeader[]>([
    {
      text: 'Name',
      value: 'name',
      class: 'min-w-[12rem]',
      sortable: true,
      filterable: true,
      filterOptions: {
        type: 'text',
      },
    },
    {
      text: 'Categories',
      value: 'categories',
    },
    {
      text: 'Variants',
      value: 'variants',
    },
    {
      text: 'Availability',
      value: 'stocks',
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
      text: 'Created',
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
      required: helpers.withMessage('Item name is required', required),
      $autoDirty: true,
    },
    description: {
      required: helpers.withMessage('Item description is required', required),
      minLengthValue: maxLength(100),
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
      createItem()

    else
      updateItem(form.id as string)
  }

  // reload items
  function reload() {
    Inertia.reload(
      {
        only: ['items'],
        onBefore: () => {
          processing = true
        },
        onFinish: () => {
          processing = false
        },
        onSuccess: () => {
          useNotificationStore().add({
            id: parseInt(_.uniqueId()),
            title: 'Items is successfully reloaded',
          })
        },
      },
    )
  }

  // get items
  function getItems(reqestData: any) {
    Inertia.get(route('admin.items.index'),
      {
        ...route().params,
        ...reqestData,
      },
      {
        preserveState: true,
        replace: true,
        only: ['items'],
        onBefore: () => {
          processing = true
        },
        onFinish: () => {
          processing = false
        },
      },
    )
  }

  // create item
  async function createItem() {
    Inertia.post(route('admin.items.store'), form as any, {
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

  // update item
  async function updateItem(id: string) {
    Inertia.put(route('admin.items.update', id), form as any, {
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

  // delete item
  function deleteItem(id: string) {
    Inertia.delete(route('admin.items.destroy', id), {
      onBefore: () => {
        processing = true
      },
      onFinish: () => {
        processing = false
      },
    })
  }

  // delete multiple items
  function deleteItems(ids: string[]) {
    Inertia.delete(route('admin.items.destroy-multiple'), {
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

  // restore item
  function restoreItem(id: string) {
    Inertia.put(route('admin.items.restore', id),
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

  // restore items
  function restoreItems(ids: string[]) {
    Inertia.put(route('admin.items.restore-multiple'),
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
    form.status = 'active'
    form.name = ''
    form.description = ''
    form.image = ''
    form.variants = []
    form.categories = []

    $v.value.$reset()
  }

  // reset form state
  function resetFormState() {
    formState.type = 'create'
    formState.show = false
    formState.title = 'New Item'
    formState.description = 'Create a new item'
  }

  return $$({
    processing,
    headers,
    $v,
    form,
    formState,

    reload,
    getItems,
    submitForm,
    resetForm,
    deleteItem,
    deleteItems,
    restoreItem,
    restoreItems,
    resetFormState,
  })
})

// make sure to pass the right store definition, `useItem` in this case.
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useItemStore, import.meta.hot))

