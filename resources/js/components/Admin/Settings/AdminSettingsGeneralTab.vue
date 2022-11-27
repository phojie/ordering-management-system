<script setup lang=ts>
const { user } = useAuthStore()

const automaticTimezoneEnabled = ref(true)
const autoUpdateApplicantDataEnabled = ref(false)
</script>

<template>
  <div class="flex flex-col space-y-10">
    <div class="divide-y divide-gray-200">
      <div class="space-y-1">
        <h3 class="text-lg font-medium leading-6 text-gray-900">
          Profile
        </h3>
        <p class="max-w-2xl text-sm text-gray-500">
          This information will be displayed publicly so be careful what you share.
        </p>
      </div>
      <div class="mt-6">
        <dl class="divide-y divide-gray-200">
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
              Name
            </dt>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <span class="flex-grow">{{ user.fullName }}</span>
              <span class="flex-shrink-0 ml-4">
                <button type="button" class="font-medium text-purple-600 bg-white rounded-md hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Update</button>
              </span>
            </dd>
          </div>
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:pt-5">
            <dt class="text-sm font-medium text-gray-500">
              Photo
            </dt>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <span class="flex-grow">
                <img class="w-8 h-8 rounded-full" :src="user.imageUrl" alt="...">
              </span>
              <span class="flex items-start flex-shrink-0 ml-4 space-x-4">
                <button type="button" class="font-medium text-purple-600 bg-white rounded-md hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Update</button>
                <span class="text-gray-300" aria-hidden="true">|</span>
                <button type="button" class="font-medium text-purple-600 bg-white rounded-md hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Remove</button>
              </span>
            </dd>
          </div>
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:pt-5">
            <dt class="text-sm font-medium text-gray-500">
              Email
            </dt>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <span class="flex-grow">{{ user.email }}</span>
              <span class="flex-shrink-0 ml-4">
                <button type="button" class="font-medium text-purple-600 bg-white rounded-md hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Update</button>
              </span>
            </dd>
          </div>
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-b sm:border-gray-200 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
              Username
            </dt>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <span class="flex-grow">{{ user.username }}</span>
              <span class="flex-shrink-0 ml-4">
                <button type="button" class="font-medium text-purple-600 bg-white rounded-md hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Update</button>
              </span>
            </dd>
          </div>
        </dl>
      </div>
    </div>

    <div class="divide-y divide-gray-200">
      <div class="space-y-1">
        <h3 class="text-lg font-medium leading-6 text-gray-900">
          Account
        </h3>
        <p class="max-w-2xl text-sm text-gray-500">
          Manage how information is displayed on your account.
        </p>
      </div>
      <div class="mt-6">
        <dl class="divide-y divide-gray-200">
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
              Language
            </dt>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <span class="flex-grow">English</span>
              <span class="flex-shrink-0 ml-4">
                <button type="button" class="font-medium text-purple-600 bg-white rounded-md hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Update</button>
              </span>
            </dd>
          </div>
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:pt-5">
            <dt class="text-sm font-medium text-gray-500">
              Date format
            </dt>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <span class="flex-grow">DD-MM-YYYY</span>
              <span class="flex items-start flex-shrink-0 ml-4 space-x-4">
                <button type="button" class="font-medium text-purple-600 bg-white rounded-md hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Update</button>
                <span class="text-gray-300" aria-hidden="true">|</span>
                <button type="button" class="font-medium text-purple-600 bg-white rounded-md hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Remove</button>
              </span>
            </dd>
          </div>
          <SwitchGroup as="div" class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:pt-5">
            <SwitchLabel as="dt" class="text-sm font-medium text-gray-500" passive>
              Automatic timezone
            </SwitchLabel>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <Switch v-model="automaticTimezoneEnabled" class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:ml-auto" :class="[automaticTimezoneEnabled ? 'bg-purple-600' : 'bg-gray-200']">
                <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform bg-white rounded-full shadow ring-0" :class="[automaticTimezoneEnabled ? 'translate-x-5' : 'translate-x-0']" />
              </Switch>
            </dd>
          </SwitchGroup>
          <SwitchGroup as="div" class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-b sm:border-gray-200 sm:py-5">
            <SwitchLabel as="dt" class="text-sm font-medium text-gray-500" passive>
              Auto-update applicant data
            </SwitchLabel>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <Switch v-model="autoUpdateApplicantDataEnabled" class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:ml-auto" :class="[autoUpdateApplicantDataEnabled ? 'bg-purple-600' : 'bg-gray-200']">
                <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform bg-white rounded-full shadow ring-0" :class="[autoUpdateApplicantDataEnabled ? 'translate-x-5' : 'translate-x-0']" />
              </Switch>
            </dd>
          </SwitchGroup>
        </dl>
      </div>
    </div>
  </div>
</template>
