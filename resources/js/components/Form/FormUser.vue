<script setup lang="ts">
const form = useUserStore().form
const formState = useUserStore().formState
const processing = useUserStore().processing
const $v = useUserStore().vuelidate
</script>

<template>
  <div class="pt-6 pb-5 space-y-6">
    <JTextField
      id="firstName"
      v-model="form.firstName"
      placeholder="John"
      label="First Name"
      :is-disabled="processing"
      :error-message="$v.firstName.$errors[0]?.$message"
      :is-dirty="$v.firstName.$error"
    />

    <JTextField
      id="middleName"
      v-model="form.middleName"
      placeholder=""
      label="Middle Name"
      :is-disabled="processing"
      hints="Optional"
    />

    <JTextField
      id="lastName"
      v-model="form.lastName"
      placeholder="Doe"
      label="Last Name"
      :is-disabled="processing"
      :error-message="$v.lastName.$errors[0]?.$message"
      :is-dirty="$v.lastName.$error"
    />

    <JTextField
      id="username"
      v-model="form.username"
      placeholder="Username"
      label="Username"
      :is-disabled="processing"
      :error-message="$v.username.$errors[0]?.$message"
      :is-dirty="$v.username.$error"
    />

    <JTextField
      id="email"
      v-model="form.email"
      placeholder="Email address"
      label="Email"
      :is-disabled="processing"
      :error-message="$v.email.$errors[0]?.$message"
      :is-dirty="$v.email.$error"
    />

    <JTextField
      v-if="formState.type === 'create'"
      id="password"
      v-model="form.password"
      type="password"
      placeholder="Password"
      label="Password"
      :is-disabled="processing"
      :error-message="$v.password.$errors[0]?.$message"
      :is-dirty="$v.password.$error"
    />

    <!-- <div v-else>
      Reset users password
    </div> -->
  </div>
</template>
