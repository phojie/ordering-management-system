<script setup lang="ts">
const { formState, resetForm, resetFormState, processing, submitForm } = useSettingStore()
const closeSlideOver = () => {
  resetForm()
  resetFormState()
}
</script>

<template>
  <JSlideOver
    :type="formState.type"
    :title="formState.title"
    :description="formState.description"
    :is-loading="processing"
    @submit="submitForm()"
    @hide="closeSlideOver()"
  >
    <div class="flex flex-col justify-between flex-1">
      <div class="px-4 divide-y divide-gray-200 sm:px-6">
        <FormSetting />
      </div>
    </div>
  </JSlideOver>
</template>
