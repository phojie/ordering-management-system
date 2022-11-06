<script setup lang="ts">
const form = useUser().form
const $v = useUser().vuelidate
</script>

<template>
  <pre>
    {{ form }}
  </pre>
  <div class="pt-6 pb-5 space-y-6">
    <JTextField
      id="username"
      v-model="form.username"
      placeholder="Username"
      :error-message="$v.username.$errors[0]?.$message"
      :is-dirty="$v.username.$error"
      label="Username"
    />

    <JTextField
      id="email"
      v-model="form.email"
      placeholder="Email address"
      :error-message="$v.email.$errors[0]?.$message"
      :is-dirty="$v.email.$error"
      label="Email"
    />

    <JTextField
      id="password"
      v-model="form.password"
      placeholder="Password"
      :error-message="$v.password.$errors[0]?.$message"
      :is-dirty="$v.password.$error"
      label="Password"
      type="password"
    />
  </div>
</template>
