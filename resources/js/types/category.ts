import type { Item } from './item'
import type { Pagination } from '@/global'

export interface Category {
  id?: string
  name: string
  description: string
  status?: string
  slug?: string
  createdAt?: string
  updatedAt?: string

  items?: Array<Item>
  itemsCount?: number
}

export interface PaginationCategories extends Pagination {
  data: Array<Category>
}

