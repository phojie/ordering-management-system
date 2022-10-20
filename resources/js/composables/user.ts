import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'

export const useUser = () => {
  const props = usePage().props.value as any

  const user = computed(() => props.auth?.user)

  // signout
  function signOut() {
    Inertia.post('/logout')
  }

  return { user, signOut }
}
