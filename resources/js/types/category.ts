import type { Pagination } from '@/global'

export interface Category {
  id?: string
  name: string
  description: string
  status?: string
  slug?: string
  createdAt?: string
  updatedAt?: string
}

export interface PaginationCategories extends Pagination {
  data: Array<Category>
}

