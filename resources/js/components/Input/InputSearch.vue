<script setup lang="ts">
import HeroiconsMagnifyingGlass20Solid from '~icons/heroicons/magnifying-glass-20-solid'

const props = defineProps<{
  modelValue?: string
  placeholder?: string
  processing?: boolean
}>()

const { modelValue: value } = defineModel<{
  modelValue: any
}>()

const { meta, control, k } = useMagicKeys()

watchEffect(() => {
  if ((meta.value && k.value) || (control.value && k.value)) {
    const input = document.querySelector('input[id="input-search"]') as HTMLInputElement
    input.focus()
  }
})
</script>

<template>
  <!-- class="col-span-3" -->
  <JTextField
    id="input-search"
    v-model="value"
    input-class="!pr-16"
    :append-inner="true"
    :prepend-inner="HeroiconsMagnifyingGlass20Solid"
    :is-loading="props.processing && value !== ''"
    :placeholder="props.placeholder ?? 'Search'"
  >
    <template #appendInner>
      <kbd
        class="inline-flex items-center px-2 font-sans text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded"
      >⌘K</kbd>
    </template>
  </JTextField>
</template>
