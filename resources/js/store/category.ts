import { helpers, maxLength, required } from '@vuelidate/validators'
import type { TableHeader } from './../j-components/types'
import type { Category } from '@/types/category'

type FormType = 'create' | 'edit'

interface FormState {
  type: FormType
  show: boolean
  title: string
  description: string
}

export const useCategoryStore = defineStore('category', () => {
  // processing state
  let processing = $ref<boolean>(false)

  // data form state
  const form = $ref<Category>({
    id: '',
    name: '',
    description: '',
    image: '',

    products: [],
  })

  // form state
  const formState = $ref<FormState>({
    type: 'create',
    show: false,
    title: 'New Category',
    description: 'Create a new category',
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
    // {
    //   text: 'Description',
    //   value: 'description',
    //   sortable: true,
    //   filterable: true,
    //   filterOptions: {
    //     type: 'text',
    //   },
    // },
    {
      text: 'Products',
      value: 'products',
    },
    {
      text: 'Status',
      value: 'status',
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
      required: helpers.withMessage('Category name is required', required),
      $autoDirty: true,
    },
    description: {
      required: helpers.withMessage('Category description is required', required),
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
      createCategory()

    else
      updateCategory(form.id as string)
  }

  // reload categories
  function reload() {
    Inertia.reload(
      {
        only: ['categories'],
        onBefore: () => {
          processing = true
        },
        onFinish: () => {
          processing = false
        },
        onSuccess: () => {
          useNotificationStore().add({
            id: parseInt(_.uniqueId()),
            title: 'Categories is successfully reloaded',
          })
        },
      },
    )
  }

  // get categories
  function getCategories(reqestData: any) {
    Inertia.get(route('admin.categories.index'),
      {
        ...route().params,
        ...reqestData,
      },
      {
        preserveState: true,
        replace: true,
        only: ['categories'],
        onBefore: () => {
          processing = true
        },
        onFinish: () => {
          processing = false
        },
      },
    )
  }

  // create category
  async function createCategory() {
    Inertia.post(route('admin.categories.store'), form as any, {
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

  // update category
  async function updateCategory(id: string) {
    Inertia.put(route('admin.categories.update', id), form as any, {
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

  // delete category
  function deleteCategory(id: string) {
    Inertia.delete(route('admin.categories.destroy', id), {
      onBefore: () => {
        processing = true
      },
      onFinish: () => {
        processing = false
      },
    })
  }

  // delete multiple categories
  function deleteCategories(ids: string[]) {
    Inertia.delete(route('admin.categories.destroy-multiple'), {
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

  // restore category
  function restoreCategory(id: string) {
    Inertia.put(route('admin.categories.restore', id),
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

  // restore categories
  function restoreCategories(ids: string[]) {
    Inertia.put(route('admin.categories.restore-multiple'),
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
    form.name = ''
    form.description = ''
    form.image = ''
    form.status = 'active'
    form.products = []

    $v.value.$reset()
  }

  // reset form state
  function resetFormState() {
    formState.type = 'create'
    formState.show = false
    formState.title = 'New Category'
    formState.description = 'Create a new category'
  }

  return $$({
    processing,
    headers,
    $v,
    form,
    formState,

    reload,
    getCategories,
    submitForm,
    resetForm,
    deleteCategory,
    deleteCategories,
    restoreCategory,
    restoreCategories,
    resetFormState,
  })
})

// make sure to pass the right store definition, `useCategory` in this case.
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useCategoryStore, import.meta.hot))

