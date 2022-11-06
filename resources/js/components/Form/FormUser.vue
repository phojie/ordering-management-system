<script setup lang="ts">
const form = useUserStore().form
const $v = useUserStore().vuelidate

// watch password changes
watch(
  () => form.password,
  (value) => {
    form.passwordConfirmation = value
  })
</script>

<template>
  <div class="pt-6 pb-5 space-y-6">
    <JTextField
      id="firstName"
      v-model="form.firstName"
      placeholder="John"
      label="First Name"
      :is-disabled="form.processing"
      :error-message="$v.firstName.$errors[0]?.$message"
      :is-dirty="$v.firstName.$error"
    />

    <JTextField
      id="middleName"
      v-model="form.middleName"
      placeholder=""
      label="Middle Name"
      :is-disabled="form.processing"
      hints="Optional"
    />

    <JTextField
      id="lastName"
      v-model="form.lastName"
      placeholder="Doe"
      label="Last Name"
      :is-disabled="form.processing"
      :error-message="$v.lastName.$errors[0]?.$message"
      :is-dirty="$v.lastName.$error"
    />

    <JTextField
      id="username"
      v-model="form.username"
      placeholder="Username"
      label="Username"
      :is-disabled="form.processing"
      :error-message="$v.username.$errors[0]?.$message"
      :is-dirty="$v.username.$error"
    />

    <JTextField
      id="email"
      v-model="form.email"
      placeholder="Email address"
      label="Email"
      :is-disabled="form.processing"
      :error-message="$v.email.$errors[0]?.$message"
      :is-dirty="$v.email.$error"
    />

    <JTextField
      id="password"
      v-model="form.password"
      type="password"
      placeholder="Password"
      label="Password"
      :is-disabled="form.processing"
      :error-message="$v.password.$errors[0]?.$message"
      :is-dirty="$v.password.$error"
    />
  </div>
</template>
