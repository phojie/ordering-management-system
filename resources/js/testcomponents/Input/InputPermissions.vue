<script setup lang="ts">
import type { Permission } from '@/types/permission'
const props = defineProps<{
  modelValue?: Array<Permission>
}>()

const emit = defineEmits(['update:modelValue'])

const value = useVModel(props, 'modelValue', emit)

const permissions = ref<Array<Permission>>([])

onMounted(async () => {
  await useFetch(route('components.permissions')).get().json().then(({ data }) => {
    permissions.value = data.value
  })
})
</script>

<template>
  <Suspense>
    <JVSelect
      v-model="value"
      label="Permissions"
      selected-label="name"
      multiple
      :options="permissions"
      :close-on-select="false"
    />

    <template #fallback>
      Loading...
    </template>
  </Suspense>
</template>
