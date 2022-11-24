<script setup lang="ts">
import type { Role } from '@/types/role'
const props = defineProps<{
  modelValue?: Array<Role>
}>()

const emit = defineEmits(['update:modelValue'])

const value = useVModel(props, 'modelValue', emit)

const roles = ref<Array<Role>>(
  [
    {
      name: 'customer',
      description: 'customer',
    },
    {
      name: 'super admin',
      description: 'Super admin',
    },
  ],
)
</script>

<template>
  <JVSelect
    v-model="value"
    label="Roles"
    selected-label="name"
    multiple
    :options="roles"
    :close-on-select="false"
  />
</template>
