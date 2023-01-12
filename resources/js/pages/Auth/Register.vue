<script setup lang="ts">
defineProps<{
}>()

const auth = useAuthStore()
const form = auth.form
const processing = computed(() => form.processing)

const isPasswordView = $ref(false)
</script>

<template>
  <Head title="Register" />
  <main class="flex flex-col justify-center py-12 overflow-auto sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <AppIcon class="w-auto mx-auto h-44" dark />
      <h2 class="mt-6 text-3xl font-bold tracking-tight text-center text-gray-900">
        Create an account
      </h2>
      <p class="mt-2 text-sm text-center text-gray-600">
        {{ ' ' }}
        <a href="#" class="font-medium text-primary-600 hover:text-primary-500">It's free, forever!</a>
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
        <form class="space-y-6" @submit.prevent="auth.register()">
          <JTextField
            id="username"
            v-model="form.username"
            placeholder="Username"
            label="Username"
            :is-disabled="processing"
            :error-message="form.errors?.username"
            :is-error="_.has(form.errors, 'username')"
          />

          <JTextField
            id="firstName"
            v-model="form.firstName"
            placeholder="John"
            label="First Name"
            :is-disabled="processing"
            :error-message="form.errors?.firstName"
            :is-error="_.has(form.errors, 'firstName')"
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
            :error-message="form.errors?.lastName"
            :is-error="_.has(form.errors, 'lastName')"
          />

          <JTextField
            id="email"
            v-model="form.email"
            :is-disabled="processing"
            label="Email address"
            :error-message="form.errors?.email"
            :is-error="_.has(form.errors, 'email')"
          />

          <JTextField
            id="password"
            v-model="form.password"
            :type="isPasswordView ? 'text' : 'password'"
            :append-inner="true"
            label="Password"
            :is-disabled="processing"
            :error-message="form.errors?.password"
            :is-error="_.has(form.errors, 'password')"
          >
            <template #appendInner>
              <span class="text-gray-500 cursor-pointer" @click="isPasswordView = !isPasswordView">
                <heroicons-eye-20-solid v-if="isPasswordView" class="w-5 h-5" />
                <heroicons-eye-slash-20-solid v-else class="w-5 h-5" />
              </span>
            </template>
          </JTextField>

          <div>
            <JBtn
              :is-disabled="processing"
              :is-loading="processing"
              type="submit"
              label="Submit"
              is-expanded
            />
          </div>
        </form>

        <div class="mt-6">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300" />
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 text-gray-500 bg-white">Or continue with</span>
            </div>
          </div>

          <div class="grid grid-cols-3 gap-3 mt-6">
            <div>
              <a
                href="#"
                class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
              >
                <span class="sr-only">Sign in with Facebook</span>
                <MingcuteFacebookFill class="w-5 h-5" />
              </a>
            </div>

            <div>
              <a
                href="#"
                class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm w-fu ll hover:bg-gray-50"
              >
                <span class="sr-only">Sign in with Twitter</span>
                <MingcuteTwitterFill class="w-5 h-5" />
              </a>
            </div>

            <div>
              <a
                href="#"
                class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
              >
                <span class="sr-only">Sign in with Google</span>
                <MingcuteGoogleFill class="w-5 h-5" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
