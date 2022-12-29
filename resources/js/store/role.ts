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
  let processing = $ref<boolean>(false)

  // data form state
  const form = $ref<Role>({
    id: '',
    name: '',
    description: '',

    permissions: [],
  })

  // form state
  const formState = $ref<FormState>({
    type: 'create',
    show: false,
    title: 'New Role',
    description: 'Create a new role',
  })

  // table headers
  const headers = $ref<TableHeader[]>([
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
          processing = true
        },
        onFinish: () => {
          processing = false
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
    Inertia.get(route('admin.roles.index'),
      {
        ...route().params,
        ...reqestData,
      },
      {
        preserveState: true,
        replace: true,
        only: ['roles'],
        onBefore: () => {
          processing = true
        },
        onFinish: () => {
          processing = false
        },
      },
    )
  }

  // create role
  async function createRole() {
    Inertia.post(route('admin.roles.store'), form, {
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
      },
    })
  }

  // update role
  async function updateRole(id: string) {
    Inertia.put(route('admin.roles.update', id), form, {
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

  // delete role
  function deleteRole(id: string) {
    Inertia.delete(route('admin.roles.destroy', id), {
      onBefore: () => {
        processing = true
      },
      onFinish: () => {
        processing = false
      },
    })
  }

  // delete multiple roles
  function deleteRoles(ids: string[]) {
    Inertia.delete(route('admin.roles.destroy-multiple'), {
      data: {
        ids,
      },
      onBefore: () => {
        processing = true
      },
      onFinish: () => {
        processing = false
      },
    })
  }

  // restore role
  function restoreRole(id: string) {
    Inertia.put(route('admin.roles.restore', id),
      {
      },
      {
        onBefore: () => {
          processing = true
        },
        onFinish: () => {
          processing = false
        },
      })
  }

  // restore roles
  function restoreRoles(ids: string[]) {
    Inertia.put(route('admin.roles.restore-multiple'),
      {
        ids,
      },
      {
        data: {
          ids,
        },
        onBefore: () => {
          processing = true
        },
        onFinish: () => {
          processing = false
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

  return $$({
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
  })
})

// make sure to pass the right store definition, `useRole` in this case.
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useRoleStore, import.meta.hot))

