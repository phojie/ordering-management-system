export const useCartStore = defineStore('cart', () => {
  // processing state
  let processing = $ref<boolean>(false)

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

  return $$({
    processing,

    deleteCart,
  })
})

// make sure to pass the right store definition, `useCart` in this case.
if (import.meta.hot)
  import.meta.hot.accept(acceptHMRUpdate(useCartStore, import.meta.hot))

