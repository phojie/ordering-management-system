<script setup lang="ts">
defineProps<{
  canResetPassword: Boolean
  status: String
}>()

const auth = useAuth()
const form = auth.form
const processing = $computed(() => form.processing)
</script>

<template>
  <Head title="Login" />
  <div class="flex flex-col justify-center min-h-full py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <AppIcon class="w-auto h-12 mx-auto" />
      <h2 class="mt-6 text-3xl font-bold tracking-tight text-center text-gray-900">
        Sign in to your account
      </h2>
      <p class="mt-2 text-sm text-center text-gray-600">
        Or
        {{ ' ' }}
        <a href="#" class="font-medium text-primary-600 hover:text-primary-500">start your 14-day free trial</a>
      </p>
    </div>

    {{ useAuth().test }}
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
        <form class="space-y-6" @submit.prevent="auth.signIn()">
          <JTextField
            id="email"
            v-model="form.email"
            :is-disabled="processing"
            label="Email address"
            :error-message="form.errors?.email"
            :is-dirty="_has(form.errors, 'email')"
          />

          <JTextField
            id="password"
            v-model="form.password"
            type="password"
            label="Password"
            :is-disabled="processing"
            :error-message="form.errors?.password"
            :is-dirty="_has(form.errors, 'password')"
          />

          <div class="flex items-center justify-between">
            <JCheckbox
              id="remember-me"
              v-model="form.remember"
              label="Remember me"
              :is-disabled="processing"
            />

            <div class="text-sm">
              <Link
                :href="route('password.request')"
                class="font-medium text-primary-600 hover:text-primary-500"
              >
                Forgot your password?
              </Link>
            </div>
          </div>

          <div>
            <JBtn
              :is-disabled="processing"
              :is-loading="processing"
              type="submit"
              label="Submit"
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
  </div>
</template>
