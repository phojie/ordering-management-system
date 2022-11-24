<script setup lang="ts">
interface VSelect {
  modelValue: any
  options: Array<string | object>
  placeholder?: string
  multiple?: boolean
  closeOnSelect?: boolean
  deselectFromDropdown?: boolean

  // extended
  id?: string
  label?: string
  selectedLabel?: string
  isError?: boolean
  isDisabled?: boolean
  isReadOnly?: boolean
  isLoading?: boolean
}

const props = withDefaults(defineProps<VSelect>(), {

})

const emit = defineEmits(['update:modelValue'])
const value = useVModel(props, 'modelValue', emit)
</script>

<template>
  <div>
    <!-- label -->
    <label
      v-if="label"
      class="block mb-1 text-sm font-medium text-gray-900"
    >
      {{ label }}
    </label>

    <!-- input wrapper -->
    <div>
      <VSelect
        v-model="value"
        :placeholder="placeholder"
        class="j-input-select"
        :label="selectedLabel"
        :multiple="multiple"
        :options="options"
        :close-on-select="closeOnSelect"
        :deselect-from-dropdown="deselectFromDropdown"
      />
    </div>
  </div>
</template>
