import type { Role } from './role'
import type { Pagination } from '@/global'

export interface User {
  username: string
  firstName: string
  lastName: string
  email: string

  id?: string
  fullName?: string
  middleName?: string
  avatar?: string
  emailVerifiedAt?: string
  createdAt?: string
  updatedAt?: string
  password?: string
  phone?: string

  address1?: string
  city?: string
  province?: string
  postalCode?: string
  address2?: string
  fullAddress?: string
  country?: string

  roles?: Array<Role | any>
}

export interface Password {
  currentPassword: string
  newPassword: string
  confirmPassword: string
}

export interface PaginationUsers extends Pagination {
  data: Array<User>
}
