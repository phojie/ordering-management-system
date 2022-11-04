import type { PaginationLink } from '@/types/constants'

export interface User {
  id: number
  username: string
  email: string
  emailVerifiedAt: string
  createdAt: string
  updatedAt: string
}

export interface Pagination {
  data: User[]
  currentPage: number
  lastPage: number
  links: Array<PaginationLink>
  nextPageUrl: string
  prevPageUrl: string
}
