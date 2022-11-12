import { email, helpers, minLength, required } from '@vuelidate/validators'
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
  })

  // form state
  const formState = reactive<FormState>({
    type: 'create',
    show: false,
    title: 'New User',
    description: 'Create a new user',
  })

  // table headers
  const headers = ref([
    {
      text: 'Username',
      value: 'username',
      class: 'min-w-[12rem] py-3.5 pr-3 text-left text-sm font-semibold text-gray-900',
    },
    {
      text: 'Title',
      value: 'title',
      class: 'px-3 py-3.5 text-left text-sm font-semibold text-gray-900',
    },
    {
      text: 'Role',
      value: 'role',
      class: 'px-3 py-3.5 text-left text-sm font-semibold text-gray-900',
    },
    {
      text: 'Status',
      value: 'status',
      class: 'px-3 py-3.5 text-left text-sm font-semibold text-gray-900',
    },
    {
      text: 'Actions',
      value: 'actions',
      class: 'px-3 py-3.5 text-left text-sm font-semibold text-gray-900',
      sortable: false,
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
  }
  const $externalResults = ref({})
  const vuelidate = useVuelidate(rules as any, form, { $externalResults })

  // submit form
  async function submitForm() {
    if (!await vuelidate.value.$validate())
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
            id: parseInt(_uniqueId()),
            title: 'Users is successfully reloaded',
            type: 'success',
            showClose: false,
            duration: 3,
          })
        },
      },
    )
  }

  // get users
  function getUsers(reqestData: any) {
    Inertia.get(route('users.index'),
      {
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
      only: ['users', 'flash'],
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
      },
    })
  }

  // update user
  async function updateUser(id: string) {
    Inertia.put(route('users.update', id), form, {
      only: ['users', 'flash'],
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
    // TODO add confirmation area here

    Inertia.delete(route('users.destroy', id), {
      only: ['users', 'flash'],
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
      only: ['users', 'flash'],
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
    form.firstName = ''
    form.middleName = ''
    form.lastName = ''
    form.imageUrl = ''
    form.username = ''
    form.email = ''
    form.password = ''

    vuelidate.value.$reset()
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
    vuelidate,
    form,
    formState,

    reload,
    getUsers,
    submitForm,
    resetForm,
    deleteUser,
    deleteUsers,
    resetFormState,
  }
})

// make sure to pass the right store definition, `useUser` in this case.
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot))

