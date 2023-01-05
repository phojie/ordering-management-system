<script setup>
const form = useForm({
  username: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false,
})

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <Head title="Register" />

  <form @submit.prevent="submit">
    <div>
      <InputLabel for="username" value="Name" />
      <TextInput id="username" v-model="form.username" type="text" class="block w-full mt-1" required autofocus autocomplete="username" />
      <InputError class="mt-2" :message="form.errors.username" />
    </div>

    <div class="mt-4">
      <InputLabel for="email" value="Email" />
      <TextInput id="email" v-model="form.email" type="email" class="block w-full mt-1" required autocomplete="username" />
      <InputError class="mt-2" :message="form.errors.email" />
    </div>

    <div class="mt-4">
      <InputLabel for="password" value="Password" />
      <TextInput id="password" v-model="form.password" type="password" class="block w-full mt-1" required autocomplete="new-password" />
      <InputError class="mt-2" :message="form.errors.password" />
    </div>

    <div class="mt-4">
      <InputLabel for="password_confirmation" value="Confirm Password" />
      <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password" class="block w-full mt-1" required autocomplete="new-password" />
      <InputError class="mt-2" :message="form.errors.password_confirmation" />
    </div>

    <div class="flex items-center justify-end mt-4">
      <Link :href="route('login')" class="text-sm text-gray-600 underline hover:text-gray-900">
        Already registered?
      </Link>

      <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Register
      </PrimaryButton>
    </div>
  </form>
</template>
