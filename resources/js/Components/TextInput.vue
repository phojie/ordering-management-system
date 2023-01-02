<script setup>
defineProps(['modelValue'])

defineEmits(['update:modelValue'])

const input = ref(null)

onMounted(() => {
  if (input.value.hasAttribute('autofocus'))
    input.value.focus()
})
</script>

<template>
  <input ref="input" class="border-gray-300 rounded-md shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
</template>
