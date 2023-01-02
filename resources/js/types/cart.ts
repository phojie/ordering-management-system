import type { Variant } from './variant'
import type { Product } from './product'

export interface Cart {
  id: number
  user_id: number
  variant_id: number
  quantity: number
  created_at?: string
  updated_at?: string

  variant: Variant
  product: Product
}
