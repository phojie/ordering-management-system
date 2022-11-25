import type { Permission } from './permission'
import type { Pagination } from '@/global'

export interface Role {
  name: string
  description?: string
  color?: string
  id?: string
  createdAt?: string
  updatedAt?: string

  permissions?: Array<Permission | any>
}

export interface PaginationRoles extends Pagination {
  data: Array<Role>
}
