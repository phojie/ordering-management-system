export const useConstant = () => {
  const paymentMethods = [
    {
      id: 1,
      title: 'Cash on delivery',
      description: 'Pay with cash upon delivery',
      disabled: false,
    },
    {
      id: 2,
      title: 'Credit card',
      description: 'Pay with your credit card',
      disabled: true,
    },
    {
      id: 3,
      title: 'Paypal',
      description: 'Pay with your paypal account',
      disabled: true,
    },
    {
      id: 2,
      title: 'GCash',
      description: 'Pay with your GCash account',
      disabled: true,
    },
  ]

  const availableAddress = [
    {
      city: 'Tubod',
      province: 'Lanao del Norte',
      postalCode: '9209',
      shippingAmount: 35,
    },
    {
      city: 'Baroy',
      province: 'Lanao del Norte',
      postalCode: '9210',
      shippingAmount: 30,
    },
    {
      city: 'Lala',
      province: 'Lanao del Norte',
      postalCode: '9211',
      shippingAmount: 45,
    },
    {
      city: 'Kapatagan',
      province: 'Lanao del Norte',
      postalCode: '9214',
      shippingAmount: 60,
    },
  ]

  const cityOptions = _.map(availableAddress, (address) => {
    return address.city
  })

  const provinceOptions = _.uniq(_.map(availableAddress, (address) => {
    return address.province
  }))

  return {
    paymentMethods,
    availableAddress,
    cityOptions,
    provinceOptions,
  }
}
