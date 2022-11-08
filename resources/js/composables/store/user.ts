import { email, helpers, minLength, required } from '@vuelidate/validators'
import type { User } from '@/types/user'

type FormType = 'Create' | 'Edit'

interface FormState {
  type: FormType
  show: boolean
  title: string
  description: string
}

export const useUserStore = defineStore('user', () => {
  const processing = ref<boolean>(false)

  // data form
  const form = reactive<User>({
    id: '',
    firstName: '',
    middleName: '',
    lastName: '',
    imageUrl: '',

    username: '',
    email: '',
    password: '',
    passwordConfirmation: '',
  })

  // form state
  const formState = reactive<FormState>({
    type: 'Create',
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
      },
    )
  }

  // submit form
  async function submitForm() {
    if (!await vuelidate.value.$validate())
      return

    if (formState.type === 'Create')
      createUser()

    else
      updateUser(form.id as string)
  }

  // create user
  async function createUser() {
    await Inertia.post(route('users.store'), form, {
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
    await Inertia.put(route('users.update', id), form, {
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
  async function deleteUser(id: string) {
    // TODO add confirmation area here

    await Inertia.delete(route('users.destroy', id), {
      only: ['users'],
      onBefore: () => {
        processing.value = true
      },
      onFinish: () => {
        processing.value = false
      },
    })
  }

  // delete multiple users
  async function deleteUsers(ids: string[]) {
    await Inertia.delete(route('users.destroy-multiple'), {
      only: ['users'],
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
    formState.type = 'Create'
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

