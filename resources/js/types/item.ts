import type { Variant } from './variant'
import type { Pagination } from '@/global'

export interface Item {
  id?: string
  name: string
  description: string
  status?: string
  slug?: string
  createdAt?: string
  updatedAt?: string

  // relationships
  variants?: Array<Variant>
}

export interface PaginationItems extends Pagination {
  data: Array<Item>
}

