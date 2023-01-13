import { email, helpers, minLength, required } from '@vuelidate/validators'
import type { Password, User } from '@/types/user'

type FormType = 'edit' | 'editPassword'

interface FormState {
  type: FormType
  show: boolean
  title: string
  description: string
}

export const useSettingStore = defineStore('setting', () => {
  // processing state
  let processing = $ref<boolean>(false)

  // data form state
  const form = $ref<User> ({
    firstName: '',
    middleName: '',
    lastName: '',
    email: '',
    username: '',
    avatar: '',
    phone: '',

    address1: '',
    city: '',
    province: '',
    postalCode: '',
  })

  const formPassword = $ref<Password>({
    currentPassword: '',
    newPassword: '',
    confirmPassword: '',
  })

  // form state
  const formState = $ref<FormState>({
    type: 'edit',
    show: false,
    title: 'Update profile',
    description: 'Update your profile information',
  })

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
    avatar: {},
    username: {
      required: helpers.withMessage('Username is required', required),
      $autoDirty: true,
    },
    email: {
      required: helpers.withMessage('Email is required', required),
      email: helpers.withMessage('Email is not valid', email),
      $autoDirty: true,
    },
    phone: {
      required: helpers.withMessage('Phone number is required', required),
      startsWith: helpers.withMessage('Phone number must start with 09', (value: string | number) => {
        return value.toString().startsWith('09') || value.toString().startsWith('09')
      }),
      length: helpers.withMessage('Phone number must be 11 digits', (value: string | number) => {
        return value.toString().length === 11
      }),
      $autoDirty: true,
    },

    address1: {
      required: helpers.withMessage('Address is required', required),
      $autoDirty: true,
    },
    city: {
      required: helpers.withMessage('City is required', required),
      $autoDirty: true,
    },
    province: {
      required: helpers.withMessage('Province is required', required),
      $autoDirty: true,
    },
    postalCode: {
      required: helpers.withMessage('Postal code is required', required),
      $autoDirty: true,
    },
  }

  const rulesPassword = {
    currentPassword: {
      required: helpers.withMessage('Current password is required', required),
      $autoDirty: true,
    },
    newPassword: {
      required: helpers.withMessage('New password is required', required),
      minLength: helpers.withMessage('Password must be at least 6 characters', minLength(6)),
      $autoDirty: true,
    },
    confirmPassword: {
      required: helpers.withMessage('Confirm password is required', required),
      $autoDirty: true,
    },
  }

  const $externalResults = ref({})
  const $v = useVuelidate(rules as any, form, { $externalResults })
  const $vFormPassword = useVuelidate(rulesPassword as any, formPassword, { $externalResults })

  // submit form
  async function submitForm() {
    // if formState.type is edit
    if (formState.type === 'edit') {
      if (!await $v.value.$validate())
        return

      updateGeneral()
    }

    // if formState.type is changePassword
    if (formState.type === 'editPassword') {
      if (!await $vFormPassword.value.$validate())
        return

      updatePassword()
    }
  }

  // update profile
  async function updateGeneral() {
    Inertia.put(route('admin.settings.update.general'), form as any, {
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

  async function updatePassword() {
    Inertia.put(route('admin.settings.update.password'), formPassword, {
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

  // reset form
  function resetForm() {
    form.firstName = ''
    form.middleName = ''
    form.lastName = ''
    form.email = ''
    form.username = ''
    form.avatar = ''
    form.phone = ''

    formPassword.newPassword = ''
    formPassword.currentPassword = ''
    formPassword.confirmPassword = ''

    $vFormPassword.value.$reset()
    $v.value.$reset()
  }

  // reset form state
  function resetFormState() {
    formState.type = 'edit'
    formState.show = false
    formState.title = 'Update profile'
    formState.description = 'Update your profile information'
  }

  return $$({
    processing,
    $v,
    $vFormPassword,
    form,
    formState,
    formPassword,

    submitForm,
    resetForm,
    resetFormState,
  })
})

if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useSettingStore, import.meta.hot))

