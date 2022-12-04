import type { Pagination } from '@/global'

export interface Item {
  id?: string
  name: string
  description: string
  status?: string
  slug?: string
  createdAt?: string
  updatedAt?: string
}

export interface PaginationItems extends Pagination {
  data: Array<Item>
}

