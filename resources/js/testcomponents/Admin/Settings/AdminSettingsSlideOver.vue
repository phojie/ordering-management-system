<script setup lang="ts">
const { formState, resetForm, resetFormState, processing, submitForm } = useSettingStore()
const closeSlideOver = () => {
  resetForm()
  resetFormState()
}
</script>

<template>
  <JSlideOver
    type="edit"
    :title="formState.title"
    :description="formState.description"
    :is-loading="processing"
    @submit="submitForm()"
    @hide="closeSlideOver()"
  >
    <div class="flex flex-col justify-between flex-1">
      <div class="px-4 divide-y divide-gray-200 sm:px-6">
        <FormSetting v-if="formState.type === 'edit'" />
        <FormPassword v-else-if="formState.type === 'editPassword'" />
      </div>
    </div>
  </JSlideOver>
</template>
