import type { User } from '@/types/user'

export const useAuthStore = defineStore('auth', () => {
  const pageProps = computed<any>(() => usePage().props.value)
  const user = computed<User>(() => pageProps.value.auth?.user)
  const roles = computed<string[]>(() => pageProps.value.auth?.roles)
  const permissions = computed<string[]>(() => pageProps.value.auth?.permissions)
  const signedIn = computed(() => pageProps.value.auth?.signedIn)

  const form = useForm({
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
    Inertia.post('/logout')
  }

  // signIn
  function signIn() {
    form.post('/login', {
      onSuccess: () => {
        form.reset()
      },
      onError: () => {
        form.password = ''
      },
    })
  }

  return {
    // states
    form,
    user,
    roles,
    permissions,
    signedIn,

    // actions
    signOut,
    signIn,
  }
})

// make sure to pass the right store definition, `useAuth` in this case.
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useAuthStore, import.meta.hot))

