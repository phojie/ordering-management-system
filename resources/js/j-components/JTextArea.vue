<script setup lang="ts">
import type { TextArea } from './types'

// set default props
const props = withDefaults(defineProps<TextArea>(), {
  rows: 4,
})

// set emits
const emit = defineEmits(['update:modelValue', 'blur'])
const value = useVModel(props, 'modelValue', emit)

// set computed
const appendInnerIcon = computed(() => {
  if (props.isLoading)
    return 'icomoon-free:spinner2'

  else if (props.isError)
    return 'heroicons:exclamation-circle-20-solid'

  else
    return props.appendInnerIcon
})

const details = computed(() => {
  if (props.isError)
    return props.errorMessage
})

// autofocus
const inputRef = ref<HTMLInputElement>()
onMounted(() => {
  if (inputRef.value?.hasAttribute('autofocus'))
    inputRef.value?.focus()
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
        v-model="value"
        :rows="props.rows"
        :readonly="isReadOnly"
        :disabled="isDisabled"
        :name="name"
        :class="[isError ? 'text-danger-900 placeholder-error-300 border-error-300 focus:border-error-500 focus:outline-none focus:ring-error-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500']"
        class="block w-full pr-10 rounded-md sm:text-sm"
      />

      <!-- append inner icon -->
      <div v-if="appendInnerIcon" class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
        <Icon :name="appendInnerIcon" class="w-5 h-5" :class="[isError ? 'text-danger-500' : 'text-gray-400', isLoading ? 'animate-spin' : '']" aria-hidden="true" />
      </div>
    </div>

    <!-- details -->
    <p
      :id="`${name}-error`"
      :class="[isError ? 'text-danger-600' : 'text-gray-500']"
      class="mt-1 text-sm"
    >
      {{ details }}
    </p>
  </div>
</template>
