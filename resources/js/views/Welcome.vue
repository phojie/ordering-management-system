<script setup>
defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
})
</script>

<template>
  <div
    class="relative flex justify-center min-h-screen items-top sm:items-center sm:pt-0"
  >
    <div v-if="canLogin" class="fixed top-0 right-0 hidden px-6 py-4 sm:block">
      <Link
        v-if="$page.props.auth.user" :href="route('dashboard')"
        class="text-sm text-gray-700 underline dark:text-gray-500"
      >
        Dashboard
      </Link>

      <template v-else>
        <Link :href="route('login')" class="text-sm text-gray-700 underline dark:text-gray-500">
          Log in
        </Link>

        <Link
          v-if="canRegister" :href="route('register')"
          class="ml-4 text-sm text-gray-700 underline dark:text-gray-500"
        >
          Register
        </Link>
      </template>
    </div>
  </div>
</template>
