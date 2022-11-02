<script setup lang="ts">
import type { TextArea } from './types'

// set default props
const props = withDefaults(defineProps<TextArea>(), {
  rows: 4,
})

// set emits
defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

// set computed
const appendInnerIcon = computed(() => {
  if (props.isLoading)
    return 'icomoon-free:spinner2'

  else if (props.isDirty)
    return 'heroicons:exclamation-circle-20-solid'

  else
    return props.appendInnerIcon
})

const details = computed(() => {
  if (props.isDirty)
    return props.errorMessage
})

// autofocus
const inputRef = $ref<HTMLInputElement>()
onMounted(() => {
  if (inputRef?.hasAttribute('autofocus'))
    inputRef?.focus()
})
</script>

<template>
  <div>
    <!-- label -->
    <label :for="id" class="block text-sm font-medium text-gray-900">{{ label }}</label>

    <!-- textarea wrapper -->
    <div class="relative mt-1 mb-2 rounded-md shadow-sm">
      <textarea
        :id="id"
        ref="inputRef"
        :rows="props.rows"
        :readonly="isReadOnly"
        :disabled="isDisabled"
        :name="name"
        :value="modelValue"
        :class="[isDirty ? 'text-error-900 placeholder-error-300 border-error-300 focus:border-error-500 focus:outline-none focus:ring-error-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500']"
        class="block w-full pr-10 rounded-md sm:text-sm"
        @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      />

      <!-- append inner icon -->
      <div v-if="appendInnerIcon" class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
        <Icon :name="appendInnerIcon" class="w-5 h-5" :class="[isDirty ? 'text-error-500' : 'text-gray-400', isLoading ? 'animate-spin' : '']" aria-hidden="true" />
      </div>
    </div>

    <!-- details -->
    <p
      :id="`${name}-error`"
      :class="[isDirty ? 'text-error-600' : 'text-gray-500']"
      class="mt-1 text-sm"
    >
      {{ details }}
    </p>
  </div>
</template>
