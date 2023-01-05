<script setup lang="ts">
const tabs = [
  { name: 'General' },
]

const { formState } = useSettingStore()
</script>

<template>
  <div class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8 lg:pb-24">
    <Head title="Settings | Customer" />
    <div class="relative px-4 sm:px-6 md:px-8 ">
      <div class="pb-16 ">
        <div class="flex justify-between space-x-5 items-center">
          <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            Account
          </h1>
          <div>
            <JBtn variant="text" @click="useAuthStore().signOut()">
              <span class="inline-flex ">
                Logout <heroicons-arrow-left-on-rectangle-20-solid class="ml-3" />
              </span>
            </JBtn>
          </div>
        </div>
        <div class="py-6">
          <TabGroup>
            <div class="border-b border-gray-200">
              <TabList class="flex -mb-px space-x-8">
                <Tab
                  v-for="tab in tabs"
                  v-slot="{ selected }"
                  :key="tab.name"
                  as="template"
                >
                  <span
                    :class="[selected ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700']"
                    class="px-1 py-4 text-sm font-medium border-b-2 cursor-pointer whitespace-nowrap"
                  >
                    {{ tab.name }}
                  </span>
                </Tab>
              </TabList>
            </div>

            <TabPanels class="mt-10">
              <TabPanel>
                <AdminSettingsGeneralTab />
              </TabPanel>
            </TabPanels>
          </TabGroup>
        </div>
      </div>
    </div>

    <!-- Slide over -->
    <AdminSettingsSlideOver :state="formState.show" />
  </div>
</template>
