<script setup lang="ts">
import type { Role } from '@/types/role'
const props = defineProps<{
  modelValue?: Array<Role>
}>()

const emit = defineEmits(['update:modelValue'])

const value = useVModel(props, 'modelValue', emit)

const roles = ref<Array<Role>>([])

onMounted(async () => {
  await useFetch(route('components.roles')).get().json().then(({ data }) => {
    roles.value = data.value
  })
})
</script>

<template>
  <Suspense>
    <JVSelect
      v-model="value"
      label="Roles"
      selected-label="name"
      multiple
      :options="roles"
      :close-on-select="false"
    />

    <template #fallback>
      Loading...
    </template>
  </Suspense>
</template>
