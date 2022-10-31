export const useAuth = defineStore('auth', () => {
  const props = usePage().props.value as any
  const auth = $computed(() => props.auth?.user)

  const form = useForm({
    email: null,
    password: null,
    remember: false,
  })

  watch(() => form.email,
    () => {
      if (_has(form.errors, 'email'))
        form.clearErrors('email')
    })

  watch(() => form.password,
    () => {
      if (_has(form.errors, 'password'))
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
        form.password = null
      },
    })
  }

  return {
    // states
    form,
    auth,

    // actions
    signOut,
    signIn,
  }
})

if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useAuth, import.meta.hot))
