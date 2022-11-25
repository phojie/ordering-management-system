import type { Pagination } from '@/global'

export interface Role {
  name: string
  description?: string
  color?: string
  id?: string
  createdAt?: string
  updatedAt?: string
}

export interface PaginationRoles extends Pagination {
  data: Array<Role>
}
