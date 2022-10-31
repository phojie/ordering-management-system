<script setup lang="ts">
defineProps<{
  status: String
}>()

const form = useForm({
  email: '',
})

const submit = () => {
  form.post(route('password.email'))
}
</script>

<template>
  <Head title="Forgot password" />

  <div class="mb-4 text-sm text-gray-600">
    Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
  </div>

  <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
    {{ status }}
  </div>

  <form @submit.prevent="submit">
    <div>
      <InputLabel for="email" value="Email" />
      <TextInput id="email" v-model="form.email" type="email" class="block w-full mt-1" required autofocus autocomplete="username" />
      <InputError class="mt-2" :message="form.errors.email" />
    </div>

    <div class="flex items-center justify-end mt-4">
      <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Email Password Reset Link
      </PrimaryButton>
    </div>
  </form>
</template>
