import { helpers, maxLength, required } from '@vuelidate/validators'
import type { TableHeader } from './../j-components/types'
import type { Product } from '@/types/product'

type FormType = 'create' | 'edit'

interface FormState {
  type: FormType
  show: boolean
  title: string
  description: string
}

export const useProductStore = defineStore('product', () => {
  // processing state
  let processing = $ref<boolean>(false)

  // data form state
  const form = $ref<Product>({
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
    title: 'New Product',
    description: 'Create a new product',
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
      required: helpers.withMessage('Product name is required', required),
      $autoDirty: true,
    },
    description: {
      required: helpers.withMessage('Product description is required', required),
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
      createProduct()

    else
      updateProduct(form.id as string)
  }

  // reload products
  function reload() {
    Inertia.reload(
      {
        only: ['products'],
        onBefore: () => {
          processing = true
        },
        onFinish: () => {
          processing = false
        },
        onSuccess: () => {
          useNotificationStore().add({
            id: parseInt(_.uniqueId()),
            title: 'Products is successfully reloaded',
          })
        },
      },
    )
  }

  // get products
  function getProducts(reqestData: any) {
    Inertia.get(route('admin.products.index'),
      {
        ...route().params,
        ...reqestData,
      },
      {
        preserveState: true,
        replace: true,
        only: ['products'],
        onBefore: () => {
          processing = true
        },
        onFinish: () => {
          processing = false
        },
      },
    )
  }

  // create product
  async function createProduct() {
    Inertia.post(route('admin.products.store'), form as any, {
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

  // update product
  async function updateProduct(id: string) {
    Inertia.put(route('admin.products.update', id), form as any, {
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

  // delete product
  function deleteProduct(id: string) {
    Inertia.delete(route('admin.products.destroy', id), {
      onBefore: () => {
        processing = true
      },
      onFinish: () => {
        processing = false
      },
    })
  }

  // delete multiple products
  function deleteProducts(ids: string[]) {
    Inertia.delete(route('admin.products.destroy-multiple'), {
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

  // restore product
  function restoreProduct(id: string) {
    Inertia.put(route('admin.products.restore', id),
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

  // restore products
  function restoreProducts(ids: string[]) {
    Inertia.put(route('admin.products.restore-multiple'),
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
    formState.title = 'New Product'
    formState.description = 'Create a new product'
  }

  return $$({
    processing,
    headers,
    $v,
    form,
    formState,

    reload,
    getProducts,
    submitForm,
    resetForm,
    deleteProduct,
    deleteProducts,
    restoreProduct,
    restoreProducts,
    resetFormState,
  })
})

// make sure to pass the right store definition, `useProduct` in this case.
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useProductStore, import.meta.hot))

