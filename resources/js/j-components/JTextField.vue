<script setup lang="ts">
import HeroiconsExclamationCircle20Solid from '~icons/heroicons/exclamation-circle-20-solid'
import IcomoonFreeSpinner2 from '~icons/icomoon-free/spinner2'
/**
  TODO: Add a way to set focus on the input
  TODO: Add hint prop
  TODO: Add persistentHint prop
  }
*/

interface Props {
  // string
  id: string
  name?: string
  type?: string
  placeholder?: string
  modelValue?: string
  label?: string
  appendInnerIcon?: string
  errorMessage?: string
  autofocus?: boolean

  // boolean
  isDirty?: boolean
  isDisabled?: boolean
  isReadOnly?: boolean
  isLoading?: boolean

  // object
}

// set default props
const props = withDefaults(defineProps<Props>(), {
  type: 'text',
})

// set emits
defineEmits<{
  (e: 'update:modelValue', value: string): void
  (e: 'blur'): void
}>()

// set computed
const appendInnerIcon = computed(() => {
  if (props.isLoading)
    return IcomoonFreeSpinner2

  else if (props.isDirty)
    return HeroiconsExclamationCircle20Solid

  else
    return props.appendInnerIcon
})

const details = computed(() => {
  if (props.isDirty)
    return props.errorMessage
})
</script>

<template>
  <div>
    <!-- label -->
    <label :for="id" class="block text-sm font-medium text-gray-900">{{ label }}</label>

    <!-- input wrapper -->
    <div class="relative mt-1 mb-2 rounded-md shadow-sm">
      <!-- input -->
      <input
        :id="id"
        :readonly="isReadOnly"
        :disabled="isDisabled"
        :value="modelValue"
        :type="type"
        :name="name"
        :autofocus="autofocus"
        :placeholder="placeholder"
        :class="[
          isDirty
            ? 'text-error-900 placeholder-error-300 border-error-300 focus:border-error-500 focus:outline-none focus:ring-error-500'
            : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500',
        ]"
        class="block w-full pr-10 rounded-md sm:text-sm"
        @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
        @blur="$emit('blur')"
      >

      <!-- append inner icon -->
      <div v-if="appendInnerIcon" class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
        <component :is="appendInnerIcon" class="w-5 h-5" :class="[isDirty ? 'text-error-500' : 'text-gray-400', isLoading ? 'animate-spin' : '']" aria-hidden="true" />
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
