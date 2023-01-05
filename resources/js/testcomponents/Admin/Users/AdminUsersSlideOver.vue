<script setup lang="ts">
const user = useUserStore()
const formState = user.formState
const closeSlideOver = () => {
  user.resetForm()
  user.resetFormState()
}
</script>

<template>
  <JSlideOver
    :type="formState.type"
    :title="formState.title"
    :description="formState.description"
    :is-loading="user.processing"
    @submit="useUserStore().submitForm()"
    @hide="closeSlideOver()"
  >
    <div class="flex flex-col justify-between flex-1">
      <div class="px-4 divide-y divide-gray-200 sm:px-6">
        <FormUser />
      </div>
    </div>
  </JSlideOver>
</template>
