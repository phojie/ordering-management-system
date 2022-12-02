<script setup lang="ts">
const { form, $v, formState } = useSettingStore()
const processing = toRef(useSettingStore(), 'processing')
</script>

<template>
  <div class="pt-6 pb-5 space-y-6">
    <JFileInput
      v-if="formState.title === 'Update photo' || formState.title === 'Update profile'"
      v-model="form.avatar"
      accepted-file-types="image/*"
      label="Photo"
    />

    <JTextField
      v-if="formState.title === 'Update name' || formState.title === 'Update profile'"
      id="firstName"
      v-model="form.firstName"
      placeholder="John"
      label="First name"
      :is-disabled="processing"
      :error-message="$v.firstName.$errors[0]?.$message"
      :is-error="$v.firstName.$error"
    />

    <JTextField
      v-if="formState.title === 'Update name' || formState.title === 'Update profile'"
      id="middleName"
      v-model="form.middleName"
      placeholder=""
      label="Middle name"
      :is-disabled="processing"
      hints="Optional"
    />

    <JTextField
      v-if="formState.title === 'Update name' || formState.title === 'Update profile'"
      id="lastName"
      v-model="form.lastName"
      placeholder="Doe"
      label="Last name"
      :is-disabled="processing"
      :error-message="$v.lastName.$errors[0]?.$message"
      :is-error="$v.lastName.$error"
    />

    <JTextField
      v-if="formState.title === 'Update username' || formState.title === 'Update profile'"
      id="username"
      v-model="form.username"
      placeholder="Username"
      label="Username"
      :is-disabled="processing"
      :error-message="$v.username.$errors[0]?.$message"
      :is-error="$v.username.$error"
    />

    <JTextField
      v-if="formState.title === 'Update email' || formState.title === 'Update profile'"
      id="email"
      v-model="form.email"
      placeholder="Email address"
      label="Email"
      :is-disabled="processing"
      :error-message="$v.email.$errors[0]?.$message"
      :is-error="$v.email.$error"
    />
  </div>
</template>
