import { defineStore } from 'pinia'
import { useVuelidate } from '@vuelidate/core'
import { helpers, required } from '@vuelidate/validators'
import type { Menu } from '~/types/menu'
import { MenuStatus } from '~/types/menu'

export const useMenuStore = defineStore('menu', () => {
  const menuForm = reactive<Menu>({
    name: '',
    description: '',
    image_url: '',
    punch_line: '',
    status: MenuStatus.ACTIVE,
  })

  const rules = {
    name: {
      required: helpers.withMessage('Name is required', required),
      $autoDirty: true,
    },
    description: { required, $autoDirty: true },
    punch_line: { required, $autoDirty: true },
    image_url: {},
    status: {},
  }

  const vuelidate = useVuelidate(rules, menuForm as any)

  // METHODS

  // fetch menus
  async function fetchMenus() {
    //  some fetch here
    return []
  }

  // create menu form
  async function submitForm() {
    const isFormCorrect = await vuelidate.value.$validate()
    // you can show some extra alert to the user or just leave the each field to show it's `$errors`.
    if (!isFormCorrect)
      console.error('Form is not correct')

    return false

    // actual submit form
  }

  // reset form
  function resetForm() {
    menuForm.name = ''
    menuForm.description = ''
    menuForm.punch_line = ''
    vuelidate.value.$reset()
  }

  return {
    // states
    menuForm,
    vuelidate,

    // methods
    fetchMenus,
    submitForm,
    resetForm,
  }
})
