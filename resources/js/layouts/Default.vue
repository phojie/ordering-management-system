<script setup>
onMounted(() => {
  if (useAuthStore().signedIn) {
    window.Echo.channel(`orders.${useAuthStore().user.id}`)
      .listen('.order.status.updated', (e) => {
        useNotificationStore().add({
          id: parseInt(_.uniqueId()),
          title: 'Order Status Updated',
          message: `Order #${e.order.orderNumber} status updated to ${e.order.status}`,
          variant: 'success',
          icon: 'check',
        })
      })
  }
})

onUnmounted(() => {
  if (useAuthStore().signedIn)
    window.Echo.leave(`orders.${useAuthStore().user.id}`)

  const chatbox = document.getElementById('fb-customer-chat')
  chatbox.setAttribute('page_id', '102728331485060')
  chatbox.setAttribute('attribution', 'biz_inbox')

  window.fbAsyncInit = function () {
    FB.init({
      xfbml: true,
    })
  };

  (function (d, s, id) {
    let js; const fjs = d.getElementsByTagName(s)[0]
    if (d.getElementById(id))
      return
    // eslint-disable-next-line prefer-const
    js = d.createElement(s); js.id = id
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js'
    fjs.parentNode.insertBefore(js, fjs)
  }(document, 'script', 'facebook-jssdk'))
})
</script>

<template>
  <div class="bg-white ">
    <AppHeader />

    <slot />

    <AppFooter />

    <AppNotification />

    <div id="fb-root" />
    <div id="fb-customer-chat" class="fb-customerchat" />
  </div>
</template>
