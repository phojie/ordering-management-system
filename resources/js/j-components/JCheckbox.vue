<script setup lang="ts">
import type { Checkbox } from './types'

withDefaults(defineProps<Checkbox>(), {
  modelValue: false,
})

// set emits
defineEmits<{
  (e: 'update:modelValue', value: boolean): void
}>()
</script>

<template>
  <div class="flex items-center">
    <input
      :id="id"
      :readonly="isReadOnly"
      :disabled="isDisabled"
      :name="name"
      class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500"
      type="checkbox"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).checked)"
    >
    <label :for="id" class="block ml-2 text-sm text-gray-900">
      {{ label }}
    </label>
  </div>
</template>
