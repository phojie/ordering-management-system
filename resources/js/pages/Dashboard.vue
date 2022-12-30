<script setup lang="ts">
const auth = useAuthStore()
</script>

<template>
  <div>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Dashboard test
    </h2>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            You're logged in! {{ auth.user.fullName }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
