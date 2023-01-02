import type { Variant } from './variant'
import type { Product } from './product'

export interface Cart {
  id: string
  user_id: string
  variant_id: string
  quantity: number
  created_at?: string
  updated_at?: string

  variant: Variant
  product: Product
}
