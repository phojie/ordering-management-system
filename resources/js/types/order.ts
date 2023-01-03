import type { OrderVariant } from './orderVariant'

export interface Order {
  id: string
  name: string
  orderNumber: number
  email: string
  phone: string
  address: string
  city: string
  province: string
  postalCode: string
  status: string

  totalAmount: number
  taxesAmount: number
  shippingAmount: number

  userId: string

  createdAt: string
  updatedAt: string

  orderVariants: Array<OrderVariant>
}
