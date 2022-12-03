<script setup lang="ts">
const { form, $v } = useRoleStore()
const processing = $computed(() => useRoleStore().processing)
</script>

<template>
  <div class="pt-6 pb-5 space-y-6">
    <JTextField
      id="name"
      v-model="form.name"
      placeholder="Name"
      label="Name"
      :is-disabled="processing"
      :error-message="$v.name.$errors[0]?.$message"
      :is-error="$v.name.$error"
    />

    <JTextArea
      id="description"
      v-model="form.description"
      placeholder="Short description"
      label="Description"
      :is-disabled="processing"
      :error-message="$v.description.$errors[0]?.$message"
      :is-error="$v.description.$error"
    />

    <InputPermissions
      v-model="form.permissions"
    />
  </div>
</template>
