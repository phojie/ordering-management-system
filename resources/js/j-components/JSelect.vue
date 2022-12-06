<script setup lang="ts">
interface Select {
  id?: string
  modelValue?: any
  items?: any
  placeholder?: string
  label?: string
  itemTitle?: string
  defaultValue?: any

  isLoading?: boolean
  isDisabled?: boolean
}

const props = withDefaults(defineProps <Select> (), {
  // defaults
})

// set emits
const emit = defineEmits(['update:modelValue', 'blur', 'input'])
const value = useVModel(props, 'modelValue', emit)
</script>

<template>
  <Listbox v-model="value" as="div" :default-value="defaultValue">
    <ListboxLabel
      v-if="props.label"
      class="block mb-1 text-sm font-medium text-gray-700"
    >
      {{ label }}
    </ListboxLabel>
    <div class="relative">
      <ListboxButton
        :disabled="isDisabled"
        class="relative w-full py-2 pl-3 pr-10 text-left bg-white border border-gray-300 rounded-md shadow-sm cursor-pointer focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 sm:text-sm"
      >
        <span class="block truncate">{{ props.itemTitle ?? value }}</span>
        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
          <heroicons-chevron-up-down class="w-5 h-5 text-gray-400" aria-hidden="true" />
        </span>
      </ListboxButton>

      <transition
        leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <ListboxOptions
          class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
        >
          <ListboxOption
            v-for="(item, id) in props.items" :key="id" v-slot="{ active, selected }" as="template"
            :value="props.itemTitle ? item[props.itemTitle] : item"
          >
            <li
              class="relative py-2 pl-3 cursor-pointer select-none pr-9" :class="[active ? 'text-white bg-primary-600' : 'text-gray-900']"
            >
              <span class="block truncate" :class="[selected ? 'font-semibold' : 'font-normal']">{{ props.itemTitle ? item[props.itemTitle] : item }}</span>

              <span
                v-if="selected"
                class="absolute inset-y-0 right-0 flex items-center pr-4" :class="[active ? 'text-white' : 'text-primary-600']"
              >
                <heroicons-check class="w-5 h-5" aria-hidden="true" />
              </span>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </transition>
    </div>
  </Listbox>
</template>
