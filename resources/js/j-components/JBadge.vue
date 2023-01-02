<script setup lang="ts">
interface JBadgeProps {
  variant?: BadgeVariant
  pill?: boolean
  size?: BadgeSize
  label?: string
}

const props = withDefaults(defineProps<JBadgeProps>(), {
  variant: 'text',
  size: 'md',
  pill: true,
})

type BadgeVariant = keyof typeof variantsLookup
type BadgeSize = keyof typeof sizesLookup

const baseClasses = 'inline-flex items-center capitalize rounded-md'

const variantsLookup = {
  text: 'bg-gray-100 text-gray-800',
  primary: 'bg-primary-100 text-primary-800',
  success: 'bg-success-100 text-success-800',
  warning: 'bg-warning-100 text-warning-800',
  danger: 'bg-danger-100 text-danger-800',
}

const sizesLookup = {
  md: 'px-2.5 py-0.5 text-xs font-medium',
}
</script>

<template>
  <span
    :class="`
      ${baseClasses}
      ${sizesLookup[size]}
      ${variantsLookup[variant]}
      ${pill ? 'rounded-full' : ''}
    `"
  >
    <slot>
      {{ props.label }}
    </slot>
  </span>
</template>
