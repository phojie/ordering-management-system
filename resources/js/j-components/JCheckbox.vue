<script setup lang="ts">
import type { Checkbox } from './types'

const props = withDefaults(defineProps<Checkbox>(), {
  modelValue: false,
})

// set emits
const emit = defineEmits(['update:modelValue'])
const value = useVModel(props, 'modelValue', emit)
</script>

<template>
  <div class="flex items-center">
    <input
      :id="id"
      v-model="value"
      :readonly="isReadOnly"
      :disabled="isDisabled"
      :name="name"
      class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500"
      type="checkbox"
    >
    <label :for="id" class="block ml-2 text-sm text-gray-900">
      {{ label }}
    </label>
  </div>
</template>
