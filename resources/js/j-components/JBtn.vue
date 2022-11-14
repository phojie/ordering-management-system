<script setup lang="ts">
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
  isIcon?: boolean
}

withDefaults(defineProps<Btn>(), {
  type: 'button',
  variant: 'primary',
  size: 'md',
  isExpanded: false,
})

type BtnVariant = keyof typeof variantsLookup
type BtnSize = keyof typeof sizesLookup

const baseClasses = 'border rounded-md focus:outline-none font-medium flex justify-center items-center'

const variantsLookup = {
  text: 'focus:ring-primary-500 bg-white hover:bg-gray-50 text-gray-700 shadow-sm border-gray-300',
  primary: 'focus:ring-primary-500 bg-primary-600 hover:bg-primary-700 text-white shadow-sm border-transparent',
  warning: 'focus:ring-warning-500 bg-warning-600 hover:bg-warning-700 text-white shadow-sm border-transparent',
  // secondary: 'bg-slate-200 text-slate-800 shadow hover:bg-slate-300 focus:bg-slate-300 focus:ring-slate-500',
  // danger: 'bg-red-500 text-white shadow-lg uppercase tracking-wider hover:bg-red-400 focus:bg-red-400 focus:ring-red-500',
}

const sizesLookup = {
  sm: 'px-3 py-1.5 text-sm focus:ring-2 focus:ring-offset-1',
  md: 'px-4 py-2 text-sm focus:ring-2 focus:ring-offset-2',
  lg: 'px-8 py-4 text-lg focus:ring focus:ring-offset-2',
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
      ${isExpanded ? 'w-full' : ''}
      ${isIcon ? 'p-0 focus:ring-2 focus:ring-offset-2' : sizesLookup[size]}
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
