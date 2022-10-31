import { email, helpers, required } from '@vuelidate/validators'
import type { Auth } from '@/types/auth'

export const useAuth = defineStore('auth', () => {
  const props = usePage().props.value as any
  const auth = $computed(() => props.auth?.user)

  const form = $ref<Auth>({
    email: '',
    password: '',
    remember: false,
    processing: false,
  })

  const rules = {
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

  const $v = useVuelidate(rules, form as Auth)

  // signout
  function signOut() {
    Inertia.post('/logout')
  }

  // signIn
  async function signIn() {
    try {
      form.processing = true
      await Inertia.post('/login', form)
    }
    catch (error) {
      form.password = ''
    }
    finally {
      form.processing = false
    }
  }

  //  validate signIn form
  async function submitForm() {
    // validate form
    const isFormCorrect = await $v.value.$validate()
    if (!isFormCorrect)
      return false

    // sign in
    signIn()
  }

  return {
    // states
    form,
    auth,
    $v,

    // methods
    signOut,
    signIn,
    submitForm,
  }
})
