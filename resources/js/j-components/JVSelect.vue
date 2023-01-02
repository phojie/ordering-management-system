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
  deselectFromDropdown: true,
  closeOnSelect: true,
})

const emit = defineEmits(['update:modelValue'])
const value = useVModel(props, 'modelValue', emit)

const isChecked = (name: string) => {
  const namesList = _.map(props.modelValue, 'name')
  if (namesList.includes(name))
    return true

  return false
}
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
      >
        <template #option="option">
          <div class="py-2">
            <JCheckbox
              :id="option.name"
              :model-value="isChecked(option.name)"
            >
              <template #label>
                {{ option.name }}
              </template>
            </JCheckbox>
          </div>
        </template>
      </VSelect>
    </div>
  </div>
</template>
