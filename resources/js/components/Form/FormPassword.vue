<script setup lang="ts">
const { formPassword: form, $vFormPassword: $v } = useSettingStore()
const processing = $computed(() => useSettingStore().processing)
</script>

<template>
  <div class="pt-6 pb-5 space-y-6">
    <JTextField
      id="current-password"
      v-model="form.currentPassword"
      type="password"
      placeholder="Password"
      label="Current password"
      :is-disabled="processing"
      :error-message="$v.currentPassword.$errors[0]?.$message"
      :is-error="$v.currentPassword.$error"
    />

    <JTextField
      id="new-password"
      v-model="form.newPassword"
      type="password"
      placeholder="Password"
      label="New password"
      :is-disabled="processing"
      :error-message="$v.newPassword.$errors[0]?.$message"
      :is-error="$v.newPassword.$error"
    />

    <JTextField
      id="confirm-password"
      v-model="form.confirmPassword"
      type="password"
      placeholder="Password"
      label="Confirm password"
      :is-disabled="processing"
      :error-message="$v.confirmPassword.$errors[0]?.$message"
      :is-error="$v.confirmPassword.$error"
    />
  </div>
</template>
