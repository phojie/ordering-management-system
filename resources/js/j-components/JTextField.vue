<script setup lang="ts">
import HeroiconsExclamationCircle20Solid from '~icons/heroicons/exclamation-circle-20-solid'

export interface Props {
  // string
  id: string
  name?: string
  type?: 'text' | 'number' | 'password' | 'tel' | 'url'
  placeholder?: string
  label?: string
  appendInner?: unknown
  prependInner?: unknown
  hints?: string
  errorMessage?: string
  inputClass?: string

  // boolean
  autofocus?: boolean
  isError?: boolean
  isDisabled?: boolean
  isReadOnly?: boolean
  isLoading?: boolean
  isClearable?: boolean

  // object
}

// set default props
const props = withDefaults(defineProps<Props>(), {
  type: 'text',
})

const { modelValue: value } = defineModel<{
  modelValue: any
}>()

// set computed
const appendInner = computed(() => {
  if (props.isError)
    return HeroiconsExclamationCircle20Solid

  else
    return props.appendInner
})

const details = computed(() => {
  if (props.isError)
    return props.errorMessage

  else
    return props.hints
})

const hasDetails = computed(() => {
  return props.isError || props.hints
})

// autofocus
const inputRef = ref<HTMLInputElement>()
onMounted(() => {
  if (inputRef.value?.hasAttribute('autofocus'))
    inputRef.value?.focus()
})
</script>

<template>
  <div class="group">
    <!-- label -->
    <label
      v-if="props.label"
      :for="id"
      class="block mb-1 text-sm font-medium text-gray-900"
    >
      <slot name="label">
        {{ label }}
      </slot>
    </label>

    <!-- input wrapper -->
    <div class="relative rounded-md shadow-sm">
      <!-- prepend inner area -->
      <div v-if="props.prependInner" class="absolute inset-y-0 left-0 flex items-center pl-3">
        <slot name="prependInner">
          <component
            :is="props.prependInner"
            class="w-5 h-5 cursor-pointer "
            :class="[
              isError
                ? 'text-danger-500'
                : 'text-gray-400',
            ]"
            aria-hidden="true"
          />
        </slot>
      </div>

      <!-- input -->
      <input
        :id="id"
        ref="inputRef"
        v-model="value"
        :readonly="isReadOnly"
        :disabled="isDisabled"
        :type="type"
        :name="name"
        :autofocus="autofocus"
        :placeholder="placeholder"
        :class="[
          isError
            ? 'text-danger-900 placeholder-danger-300 border-danger-300 focus:border-danger-500 focus:outline-none focus:ring-danger-500'
            : 'border-gray-300 focus:border-primary-500 focus:ring-primary-500',
          props.prependInner
            ? 'pl-10'
            : 'pl-3',
          appendInner
            ? 'pr-10'
            : 'pr-3',
          props.inputClass,
        ]"
        class="block w-full pr-10 rounded-md sm:text-sm placeholder:font-normal"
      >

      <div v-if="appendInner || isLoading || isClearable" class="absolute inset-y-0 right-0 flex items-center pr-3">
        <!-- append inner area -->
        <slot
          v-if="!isLoading"
          name="appendInner"
        >
          <component
            :is="appendInner"
            v-if="appendInner"
            class="w-5 h-5 cursor-pointer"
            :class="[
              isError
                ? 'text-danger-500'
                : 'text-gray-400',
            ]"
            aria-hidden="true"
          />
        </slot>

        <!-- default spinner area -->
        <JSpinner v-if="isLoading" class="w-5 h-5 text-gray-400" />

        <!-- clearable area -->
        <heroicons-x-mark-20-solid
          v-if="isClearable && !appendInner"
          class="invisible w-5 h-5 text-gray-400 cursor-pointer group-hover:visible hover:text-gray-500"
          @click="value = ''"
        />
      </div>
    </div>

    <!-- details -->
    <p
      v-if="hasDetails"
      :id="`${id}-details`"
      :class="[isError ? 'text-danger-600' : 'text-gray-500']"
      class="mt-1 text-sm"
    >
      {{ details }}
    </p>
  </div>
</template>
