<script setup lang="ts">
import type { Btn } from './types'

// set default props
withDefaults(defineProps<Btn>(), {
  type: 'button',
})
</script>

<template>
  <button
    :type="type"
    :readonly="isReadOnly"
    :disabled="isDisabled"
    class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
  >
    <span v-if="!isLoading">
      <!-- label area -->
      {{ label }}
      <template v-if="label">
        <slot />
      </template>
    </span>

    <span v-if="isLoading" class="flex space-x-2">
      <!-- spinner area -->
      <JSpinner class="w-5 h-5 " />
      <span>
        Processing...
      </span>
    </span>
  </button>
</template>
