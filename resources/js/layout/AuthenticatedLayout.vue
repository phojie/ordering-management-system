<script setup>
const showingNavigationDropdown = ref(false)
</script>

<template>
  <div>
    <div class="min-h-screen bg-gray-100">
      <!-- Page Heading -->
      <header v-if="$slots.header" class="bg-white shadow">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>

