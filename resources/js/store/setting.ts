import { email, helpers, required } from '@vuelidate/validators'
import type { User } from '@/types/user'

type FormType = 'create' | 'edit'

interface FormState {
  type: FormType
  show: boolean
  title: string
  description: string
}

export const useSettingStore = defineStore('setting', () => {
  // processing state
  const processing = ref<boolean>(false)

  // data form state
  const form = reactive<User>({
    firstName: '',
    middleName: '',
    lastName: '',
    email: '',
    username: '',
    imageUrl: '',
  })

  // form state
  const formState = reactive<FormState>({
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
  }

  const $externalResults = ref({})
  const $v = useVuelidate(rules as any, form, { $externalResults })

  // submit form
  async function submitForm() {
    if (!await $v.value.$validate())
      return

    updateProfile()
  }

  // update profile
  async function updateProfile() {
    Inertia.put(route('settings.update'), form, {
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

  // reset form
  function resetForm() {
    form.id = ''
    $v.value.$reset()
  }

  // reset form state
  function resetFormState() {
    formState.type = 'edit'
    formState.show = false
    formState.title = 'Update profile'
    formState.description = 'Update your profile information'
  }

  return {
    processing,
    $v,
    form,
    formState,

    submitForm,
    resetForm,
    resetFormState,
  }
})

if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useSettingStore, import.meta.hot))

