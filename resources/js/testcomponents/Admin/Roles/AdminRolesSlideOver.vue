<script setup lang="ts">
const role = useRoleStore()
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
    @submit="useRoleStore().submitForm()"
    @hide="closeSlideOver()"
  >
    <div class="flex flex-col justify-between flex-1">
      <div class="px-4 divide-y divide-gray-200 sm:px-6">
        <FormRole />
      </div>
    </div>
  </JSlideOver>
</template>
