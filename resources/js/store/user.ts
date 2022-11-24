import { email, helpers, minLength, required } from '@vuelidate/validators'
import type { TableHeader } from './../j-components/types'
import type { User } from '@/types/user'

type FormType = 'create' | 'edit'

interface FormState {
  type: FormType
  show: boolean
  title: string
  description: string
}

export const useUserStore = defineStore('user', () => {
  // processing state
  const processing = ref<boolean>(false)

  // data form state
  const form = reactive<User>({
    id: '',
    firstName: '',
    middleName: '',
    lastName: '',
    imageUrl: '',

    username: '',
    email: '',
    password: '',

    roles: [],
  })

  // form state
  const formState = reactive<FormState>({
    type: 'create',
    show: false,
    title: 'New User',
    description: 'Create a new user',
  })

  // table headers
  const headers = ref<TableHeader[]>([
    {
      text: 'Name',
      value: 'full_name',
      class: 'min-w-[12rem]',
      sortable: true,
      filterable: true,
      filterOptions: {
        type: 'text',
      },
    },
    {
      text: 'Username',
      value: 'username',
      sortable: true,
      filterable: true,
      filterOptions: {
        type: 'text',
      },
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
      text: 'Role',
      value: 'roles.name',
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
    firstName: {
      required: helpers.withMessage('First name is required', required),
      $autoDirty: true,
    },
    middleName: {},
    lastName: {
      required: helpers.withMessage('Last name is required', required),
      $autoDirty: true,
    },
    imageUrl: {},
    username: {
      required: helpers.withMessage('Username is required', required),
      $autoDirty: true,
    },
    email: {
      required: helpers.withMessage('Email is required', required),
      email: helpers.withMessage('Email is not valid', email),
      $autoDirty: true,
    },
    password: {
      required: helpers.withMessage('Password is required', required),
      minLength: helpers.withMessage('Password must be at least 6 characters', minLength(6)),
      $autoDirty: true,
    },
    roles: {
    },
  }

  const $externalResults = ref({})
  const $v = useVuelidate(rules as any, form, { $externalResults })

  // submit form
  async function submitForm() {
    if (!await $v.value.$validate())
      return

    if (formState.type === 'create')
      createUser()

    else
      updateUser(form.id as string)
  }

  // reload users
  function reload() {
    Inertia.reload(
      {
        only: ['users'],
        onBefore: () => {
          processing.value = true
        },
        onFinish: () => {
          processing.value = false
        },
        onSuccess: () => {
          useNotificationStore().add({
            id: parseInt(_.uniqueId()),
            title: 'Users is successfully reloaded',
          })
        },
      },
    )
  }

  // get users
  function getUsers(reqestData: any) {
    Inertia.get(route('users.index'),
      {
        ...route().params,
        ...reqestData,
      },
      {
        preserveState: true,
        replace: true,
        only: ['users'],
        onBefore: () => {
          processing.value = true
        },
        onFinish: () => {
          processing.value = false
        },
      },
    )
  }

  // create user
  async function createUser() {
    Inertia.post(route('users.store'), form, {
      onBefore: () => {
        processing.value = true
      },
      onFinish: () => {
        processing.value = false
      },
      onError: (error) => {
        $externalResults.value = error
      },
      onSuccess: () => {
        // resetForm()
      },
    })
  }

  // update user
  async function updateUser(id: string) {
    Inertia.put(route('users.update', id), form, {
      onBefore: () => {
        processing.value = true
      },
      onFinish: () => {
        processing.value = false
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

  // delete user
  function deleteUser(id: string) {
    Inertia.delete(route('users.destroy', id), {
      onBefore: () => {
        processing.value = true
      },
      onFinish: () => {
        processing.value = false
      },
    })
  }

  // delete multiple users
  function deleteUsers(ids: string[]) {
    Inertia.delete(route('users.destroy-multiple'), {
      data: {
        ids,
      },
      onBefore: () => {
        processing.value = true
      },
      onFinish: () => {
        processing.value = false
      },
    })
  }

  // restore user
  function restoreUser(id: string) {
    Inertia.put(route('users.restore', id),
      {
      },
      {
        onBefore: () => {
          processing.value = true
        },
        onFinish: () => {
          processing.value = false
        },
      })
  }

  // restore users
  function restoreUsers(ids: string[]) {
    Inertia.put(route('users.restore-multiple'),
      {
        ids,
      },
      {
        data: {
          ids,
        },
        onBefore: () => {
          processing.value = true
        },
        onFinish: () => {
          processing.value = false
        },
      })
  }

  // reset form
  function resetForm() {
    form.id = ''
    form.firstName = ''
    form.middleName = ''
    form.lastName = ''
    form.imageUrl = ''
    form.username = ''
    form.email = ''
    form.password = ''
    form.roles = []

    $v.value.$reset()
  }

  // reset form state
  function resetFormState() {
    formState.type = 'create'
    formState.show = false
    formState.title = 'New User'
    formState.description = 'Create a new user'
  }

  return {
    processing,
    headers,
    $v,
    form,
    formState,

    reload,
    getUsers,
    submitForm,
    resetForm,
    deleteUser,
    deleteUsers,
    restoreUser,
    restoreUsers,
    resetFormState,
  }
})

// make sure to pass the right store definition, `useUser` in this case.
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot))

