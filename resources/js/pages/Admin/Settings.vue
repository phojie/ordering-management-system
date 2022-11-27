<script setup>
defineOptions({
  layout: AdminLayout,
})

const tabs = [
  { name: 'General' },
]

const { formState } = useSettingStore()
</script>

<template>
  <main>
    <Head title="Settings | Admin" />
    <div class="relative px-4 sm:px-6 md:px-8 ">
      <div class="pt-10 pb-16">
        <div>
          <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            Settings
          </h1>
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
  </main>
</template>
