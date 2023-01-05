<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3'

const form = useForm({
  password: '',
})

const submit = () => {
  form.post(route('password.confirm'), {
    onFinish: () => form.reset(),
  })
}
</script>

<template>
  <GuestLayout>
    <Head title="Confirm Password" />

    <div class="mb-4 text-sm text-gray-600">
      This is a secure area of the application. Please confirm your password before continuing.
    </div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="password" value="Password" />
        <TextInput id="password" v-model="form.password" type="password" class="block w-full mt-1" required autocomplete="current-password" autofocus />
        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="flex justify-end mt-4">
        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Confirm
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
