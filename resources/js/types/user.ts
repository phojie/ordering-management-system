import type { Pagination } from '@/global'

export interface User {
  username: string
  firstName: string
  lastName: string
  email: string

  id?: string
  fullName?: string
  middleName?: string
  imageUrl?: string
  emailVerifiedAt?: string
  createdAt?: string
  updatedAt?: string
  password?: string
  passwordConfirmation?: string
}

export interface PaginationUsers extends Pagination {
  data: Array<User>
}
