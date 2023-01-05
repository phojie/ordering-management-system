import type { User } from '@/types/user'

export const useAuthStore = defineStore('auth', () => {
  const auth = $computed<any>(() => usePage().props.value.auth)
  const user = $computed<User>(() => auth?.user)
  const roles = $computed<string[]>(() => auth?.roles)
  const permissions = $computed<string[]>(() => auth?.permissions)
  const signedIn = $computed(() => auth?.signedIn)
  const csrfToken = $computed(() => usePage().props.value.csrfToken)

  const form = useForm({
    firstName: '',
    middleName: '',
    lastName: '',
    username: '',

    email: '',
    password: '',
    remember: false,
  })

  watch(() => form.email,
    () => {
      if (_.has(form.errors, 'email'))
        form.clearErrors('email')
    })

  watch(() => form.password,
    () => {
      if (_.has(form.errors, 'password'))
        form.clearErrors('password')
    })

  // signout
  function signOut() {
    Inertia.post(route('logout'), {
      _token: csrfToken as string,
    })
  }

  // signIn
  function signIn() {
    form.post(route('login'), {
      onSuccess: () => {
        form.reset()
      },
      onError: () => {
        form.password = ''
      },
    })
  }

  // register
  function register() {
    form.post(route('register'), {
      onSuccess: () => {
        form.reset()
      },
      onError: () => {
        form.password = ''
      },
    })
  }

  return $$({
    // states
    form,
    user,
    roles,
    permissions,
    signedIn,

    // actions
    signOut,
    signIn,
    register,
  })
})

// make sure to pass the right store definition, `useAuth` in this case.
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useAuthStore, import.meta.hot))

