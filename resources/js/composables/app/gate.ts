export const useGate = () => {
  const { roles, permissions } = useAuthStore()

  const can = (permission: string) => {
    return _.includes(permissions, permission) || _.includes(roles, permission) || _.includes(roles, 'Super Admin')
  }

  return {
    can,
  }
}
