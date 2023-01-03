import type { Variant } from './variant'
import type { Product } from './product'

export interface OrderVariant {
  id: string

  orderId: string
  productId: string
  variantId: string
  quantity: number
  price: number
  total: number
  status: string

  createdAt: string
  updatedAt: string

  product: Product
  variant: Variant
}
