<script setup lang="ts">
const role = useProductStore()
const formState = role.formState
const closeSlideOver = () => {
  role.resetForm()
  role.resetFormState()
}
</script>

<template>
  <JSlideOver
    :type="formState.type"
    :title="formState.title"
    :description="formState.description"
    :is-loading="role.processing"
    size="xl"
    @submit="useProductStore().submitForm()"
    @hide="closeSlideOver()"
  >
    <div class="flex flex-col justify-between flex-1">
      <div class="px-4 divide-y divide-gray-200 sm:px-6">
        <FormProduct />
      </div>
    </div>
  </JSlideOver>
</template>
