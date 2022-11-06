import { email, helpers, required } from '@vuelidate/validators'
import type { User } from '@/types/user'

export const useUser = defineStore('user', () => {
  const form = reactive<User | any>({
    username: '',
    email: '',
    password: '',
  })

  const rules = {
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
      $autoDirty: true,
    },
  }

  const $externalResults = ref({})

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

  const processing = ref<boolean>(false)

  const vuelidate = useVuelidate(rules, form, { $externalResults })

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

  // create user
  async function submitForm() {
    if (!await vuelidate.value.$validate())
      return

    createUser()
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

  // delete user
  async function deleteUser(id: number) {
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
  async function deleteUsers(ids: number[]) {
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
    // reset form
    form.username = ''
    form.email = ''
    form.password = ''

    vuelidate.value.$reset()
  }

  return {
    processing,
    headers,
    vuelidate,
    form,

    reload,
    submitForm,
    deleteUser,
    deleteUsers,
  }
})

// make sure to pass the right store definition, `useUser` in this case.
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useUser, import.meta.hot))

