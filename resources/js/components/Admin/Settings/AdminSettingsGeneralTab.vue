<script setup lang="ts">
const user = toRef(useAuthStore(), 'user')
const { form, formState } = useSettingStore()

const disableSingleUpdate = $computed(() => {
  if (user.value.phone == null || user.value.address1 == null)
    return true

  return false
})

const toggleEdit = (title: string, type?: 'edit' | 'editPassword') => {
  form.firstName = user.value.firstName
  form.middleName = user.value.middleName
  form.lastName = user.value.lastName
  form.username = user.value.username
  form.avatar = user.value.avatar
  form.email = user.value.email
  form.phone = user.value.phone
  form.address1 = user.value.address1
  form.city = user.value.city
  form.province = user.value.province
  form.postalCode = user.value.postalCode

  formState.show = true
  formState.title = title
  formState.type = type ?? 'edit'
}
</script>

<template>
  <div class="flex flex-col space-y-10">
    <div class="divide-y divide-gray-200 group">
      <div class="space-y-1">
        <div class="flex items-center justify-between space-x-2">
          <h3 class="text-lg font-medium leading-6 text-gray-900">
            Profile
          </h3>
          <button
            type="button"
            class="hover:text-primary-500 text-primary-600"
            @click="toggleEdit('Update profile')"
          >
            <heroicons-pencil-square-20-solid class="w-6 h-6 " />
          </button>
        </div>

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
                <button
                  type="button"
                  :disabled="disableSingleUpdate"
                  class="font-medium rounded-md text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                  @click="toggleEdit('Update name')"
                >
                  Update
                </button>
              </span>
            </dd>
          </div>
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:pt-5">
            <dt class="text-sm font-medium text-gray-500">
              Photo
            </dt>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <span class="flex-grow">
                <img class="w-8 h-8 rounded-full" :src="user.avatar" alt="...">
              </span>
              <span class="flex items-start flex-shrink-0 ml-4 space-x-4">
                <button
                  type="button"
                  :disabled="disableSingleUpdate"
                  class="font-medium rounded-md text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                  @click="toggleEdit('Update photo')"
                >Update</button>
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
                <button
                  type="button"
                  :disabled="disableSingleUpdate"
                  class="font-medium rounded-md text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                  @click="toggleEdit('Update email')"
                >Update</button>
              </span>
            </dd>
          </div>
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:pt-5">
            <dt class="text-sm font-medium text-gray-500">
              Phone
            </dt>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <span class="flex-grow">{{ user.phone }}</span>
              <span class="flex-shrink-0 ml-4">
                <button
                  type="button"
                  :disabled="disableSingleUpdate"
                  class="font-medium rounded-md text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                  @click="toggleEdit('Update phone')"
                >Update</button>
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
                <button
                  :disabled="disableSingleUpdate"
                  type="button"
                  class="font-medium rounded-md text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                  @click="toggleEdit('Update username')"
                >Update</button>
              </span>
            </dd>
          </div>

          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-b sm:border-gray-200 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
              Address
            </dt>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <span class="flex-grow">{{ user.fullAddress }}</span>
              <span class="flex-shrink-0 ml-4">
                <button
                  :disabled="disableSingleUpdate"
                  type="button"
                  class="font-medium rounded-md text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                  @click="toggleEdit('Update address')"
                >Update</button>
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
              Password
            </dt>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <span class="flex-grow">*******</span>
              <span class="flex-shrink-0 ml-4">
                <button
                  type="button"
                  class="font-medium rounded-md text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                  @click="toggleEdit('Update password', 'editPassword')"
                >
                  Reset
                </button>
              </span>
            </dd>
          </div>
          <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
              Language
            </dt>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <span class="flex-grow">English</span>
              <span class="flex-shrink-0 ml-4">
                <button
                  disabled
                  type="button"
                  class="font-medium rounded-md text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                >
                  Update
                </button>
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
                <button
                  disabled
                  type="button"
                  class="font-medium rounded-md text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                >
                  Update
                </button>
              </span>
            </dd>
          </div>
          <SwitchGroup as="div" class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:pt-5">
            <SwitchLabel as="dt" class="text-sm font-medium text-gray-500" passive>
              Automatic timezone
            </SwitchLabel>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <JSwitch
                :model-value="true"
                disabled
              />
            </dd>
          </SwitchGroup>
          <SwitchGroup as="div" class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-b sm:border-gray-200 sm:py-5">
            <SwitchLabel as="dt" class="text-sm font-medium text-gray-500" passive>
              Automatic updates
            </SwitchLabel>
            <dd class="flex mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <JSwitch
                :model-value="true"
                disabled
              />
            </dd>
          </SwitchGroup>
        </dl>
      </div>
    </div>
  </div>
</template>
