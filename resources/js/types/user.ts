import type { PaginationLink } from '~/global'

export interface User {
  id?: number
  username: string
  email: string
  emailVerifiedAt?: string
  createdAt?: string
  updatedAt?: string
  password?: string
  passwordConfirmation?: string
}

export interface Pagination {
  data: Array<User>
  links: Array<any>
  meta: PaginationMeta
}

interface PaginationMeta {
  current_page: number
  from: number
  last_page: number
  path: string
  links: Array<PaginationLink>
  per_page: number
  to: number
  total: number
}

