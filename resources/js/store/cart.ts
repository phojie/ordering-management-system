export const useCartStore = defineStore('cart', () => {
  // processing state
  let processing = $ref<boolean>(false)

  // updateCart
  function updateCart(id: string, quantity: number) {
    Inertia.put(route('customer.carts.update', id), {
      quantity,
    }, {
      onBefore: () => {
        processing = true
      },
      onFinish: () => {
        processing = false
      },
    })
  }

  // delete cart
  function deleteCart(id: string) {
    Inertia.delete(route('customer.carts.destroy', id), {
      onBefore: () => {
        processing = true
      },
      onFinish: () => {
        processing = false
      },
    })
  }

  // checkout cart
  function checkoutCart() {
    Inertia.post(route('customer.carts.checkout'),
      {}, {
        onBefore: () => {
          processing = true
        },
        onFinish: () => {
          processing = false
        },
      })
  }

  return $$({
    processing,

    updateCart,
    deleteCart,
    checkoutCart,
  })
})

// make sure to pass the right store definition, `useCart` in this case.
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useCartStore, import.meta.hot))

