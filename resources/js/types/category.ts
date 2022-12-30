import type { Product } from './product'
import type { Pagination } from '@/global'

export interface Category {
  id?: string
  name: string
  description: string
  status?: string
  slug?: string
  image?: string
  createdAt?: string
  updatedAt?: string

  products?: Array<Product>
  productsCount?: number
}

export interface PaginationCategories extends Pagination {
  data: Array<Category>
}

