<script setup lang="ts">
withDefaults(defineProps<Btn>(), {
  type: 'button',
  variant: 'primary',
  size: 'medium',
  isExpanded: true,
})

type BtnVariant = keyof typeof variantsLookup
type BtnSize = keyof typeof sizesLookup

interface Btn {
  // string
  id?: string
  name?: string
  type?: 'submit' | 'reset' | 'button'
  label?: string
  variant?: BtnVariant
  size?: BtnSize

  // boolean
  isDirty?: boolean
  isDisabled?: boolean
  isReadOnly?: boolean
  isLoading?: boolean
  isExpanded?: boolean
}

const baseClasses = 'border border-transparent rounded-md focus:outline-none font-medium flex justify-center items-center'

const variantsLookup = {
  primary: 'focus:ring-primary-500 bg-primary-600 hover:bg-primary-700 text-white shadow-sm',
  // secondary: 'bg-slate-200 text-slate-800 shadow hover:bg-slate-300 focus:bg-slate-300 focus:ring-slate-500',
  // danger: 'bg-red-500 text-white shadow-lg uppercase tracking-wider hover:bg-red-400 focus:bg-red-400 focus:ring-red-500',
  // text: 'text-slate-700 uppercase underline hover:text-slate-600 hover:bg-slate-900/5 focus:text-slate-600 focus:ring-slate-500',
}

const sizesLookup = {
  small: 'px-3 py-1.5 text-sm focus:ring-2 focus:ring-offset-1',
  medium: 'px-4 py-2 text-sm focus:ring-2 focus:ring-offset-2',
  large: 'px-8 py-4 text-lg focus:ring focus:ring-offset-2',
}
</script>

<template>
  <button
    :type="type"
    :readonly="isReadOnly"
    :disabled="isDisabled"
    :class="`
      ${baseClasses}
      ${variantsLookup[variant]}
      ${sizesLookup[size]}
      ${isExpanded ? 'w-full' : ''}
    `"
  >
    <span v-if="!isLoading">
      <!-- label area -->
      <slot>
        {{ label }}
      </slot>
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
