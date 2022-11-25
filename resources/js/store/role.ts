import { helpers, maxLength, required } from '@vuelidate/validators'
import type { TableHeader } from './../j-components/types'
import type { Role } from '@/types/role'

type FormType = 'create' | 'edit'

interface FormState {
  type: FormType
  show: boolean
  title: string
  description: string
}

export const useRoleStore = defineStore('role', () => {
  // processing state
  const processing = ref<boolean>(false)

  // data form state
  const form = reactive<Role>({
    id: '',
    name: '',
    description: '',
    color: '',

    permissions: [],
  })

  // form state
  const formState = reactive<FormState>({
    type: 'create',
    show: false,
    title: 'New Role',
    description: 'Create a new role',
  })

  // table headers
  const headers = ref<TableHeader[]>([
    {
      text: 'Name',
      value: 'name',
      class: 'min-w-[12rem]',
      sortable: true,
      filterable: true,
      filterOptions: {
        type: 'text',
      },
    },
    {
      text: 'Description',
      value: 'description',
      sortable: true,
      filterable: true,
      filterOptions: {
        type: 'text',
      },
    },
    {
      text: 'Permissions',
      value: 'permissions',
    },
    {
      text: 'Status',
      value: 'status',
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
    name: {
      required: helpers.withMessage('Role name is required', required),
      $autoDirty: true,
    },
    description: {
      required: helpers.withMessage('Role description is required', required),
      minLengthValue: maxLength(100),
      $autoDirty: true,
    },
    permissions: {},
  }

  const $externalResults = ref({})
  const $v = useVuelidate(rules as any, form, { $externalResults })

  // submit form
  async function submitForm() {
    if (!await $v.value.$validate())
      return

    if (formState.type === 'create')
      createRole()

    else
      updateRole(form.id as string)
  }

  // reload roles
  function reload() {
    Inertia.reload(
      {
        only: ['roles'],
        onBefore: () => {
          processing.value = true
        },
        onFinish: () => {
          processing.value = false
        },
        onSuccess: () => {
          useNotificationStore().add({
            id: parseInt(_.uniqueId()),
            title: 'Roles is successfully reloaded',
          })
        },
      },
    )
  }

  // get roles
  function getRoles(reqestData: any) {
    Inertia.get(route('roles.index'),
      {
        ...route().params,
        ...reqestData,
      },
      {
        preserveState: true,
        replace: true,
        only: ['roles'],
        onBefore: () => {
          processing.value = true
        },
        onFinish: () => {
          processing.value = false
        },
      },
    )
  }

  // create role
  async function createRole() {
    Inertia.post(route('roles.store'), form, {
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

  // update role
  async function updateRole(id: string) {
    Inertia.put(route('roles.update', id), form, {
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

  // delete role
  function deleteRole(id: string) {
    Inertia.delete(route('roles.destroy', id), {
      onBefore: () => {
        processing.value = true
      },
      onFinish: () => {
        processing.value = false
      },
    })
  }

  // delete multiple roles
  function deleteRoles(ids: string[]) {
    Inertia.delete(route('roles.destroy-multiple'), {
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

  // restore role
  function restoreRole(id: string) {
    Inertia.put(route('roles.restore', id),
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

  // restore roles
  function restoreRoles(ids: string[]) {
    Inertia.put(route('roles.restore-multiple'),
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
    form.name = ''
    form.description = ''
    form.color = ''
    form.permissions = []

    $v.value.$reset()
  }

  // reset form state
  function resetFormState() {
    formState.type = 'create'
    formState.show = false
    formState.title = 'New Role'
    formState.description = 'Create a new role'
  }

  return {
    processing,
    headers,
    $v,
    form,
    formState,

    reload,
    getRoles,
    submitForm,
    resetForm,
    deleteRole,
    deleteRoles,
    restoreRole,
    restoreRoles,
    resetFormState,
  }
})

// make sure to pass the right store definition, `useRole` in this case.
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useRoleStore, import.meta.hot))

