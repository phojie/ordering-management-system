<script setup lang="ts">
import type { TextField } from './types'
import HeroiconsExclamationCircle20Solid from '~icons/heroicons/exclamation-circle-20-solid'

/**
  TODO: Add a way to set focus on the input
  TODO: Add hint prop
  TODO: Add persistentHint prop
  }
*/

// set default props
const props = withDefaults(defineProps<TextField>(), {
  type: 'text',
})

// set emits
defineEmits<{
  (e: 'update:modelValue', value: string): void
  (e: 'blur'): void
}>()

// set computed
const appendInnerIcon = computed(() => {
  if (props.isDirty)
    return HeroiconsExclamationCircle20Solid

  else
    return props.appendInnerIcon
})

const details = computed(() => {
  if (props.isDirty)
    return props.errorMessage

  else
    return props.hints
})

const hasDetails = computed(() => {
  return props.isDirty || props.hints
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
    <label
      v-if="props.label"
      :for="id" class="block mb-1 text-sm font-medium text-gray-900"
    >{{ label }}</label>

    <!-- input wrapper -->
    <div class="relative rounded-md shadow-sm">
      <!-- input -->
      <input
        :id="id"
        ref="inputRef"
        :readonly="isReadOnly"
        :disabled="isDisabled"
        :value="modelValue"
        :type="type"
        :name="name"
        :autofocus="autofocus"
        :placeholder="placeholder"
        :class="[
          isDirty
            ? 'text-danger-900 placeholder-danger-300 border-danger-300 focus:border-danger-500 focus:outline-none focus:ring-danger-500'
            : 'border-gray-300 focus:border-primary-500 focus:ring-primary-500',
        ]"
        class="block w-full pr-10 rounded-md sm:text-sm"
        @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
        @blur="$emit('blur')"
      >

      <!-- append inner area -->
      <div v-if="appendInnerIcon || isLoading" class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
        <!-- icon area -->
        <component
          :is="appendInnerIcon"
          class="w-5 h-5" :class="[
            isDirty
              ? 'text-danger-500'
              : 'text-gray-400',
            { 'animate-spin': isLoading },
          ]"
          aria-hidden="true"
        />

        <!-- spinner area -->
        <JSpinner v-if="isLoading" class="w-5 h-5 text-gray-400" />
      </div>
    </div>

    <!-- details -->
    <p
      v-if="hasDetails"
      :id="`${id}-details`"
      :class="[isDirty ? 'text-danger-600' : 'text-gray-500']"
      class="mt-3 text-sm"
    >
      {{ details }}
    </p>
  </div>
</template>
