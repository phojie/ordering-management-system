<script setup>
import { computed } from 'vue'

const props = defineProps({
  checked: {
    type: [Array, Boolean],
    default: false,
  },
  value: {
    default: null,
  },
})

const emit = defineEmits(['update:checked'])

const proxyChecked = computed({
  get() {
    return props.checked
  },

  set(val) {
    emit('update:checked', val)
  },
})
</script>

<template>
  <input
    v-model="proxyChecked" type="checkbox" :value="value"
    class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
  >
</template>
