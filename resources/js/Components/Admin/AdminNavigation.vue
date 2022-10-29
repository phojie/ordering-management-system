<script setup lang="ts">
const { adminItems, miscItems } = useNavigation()
</script>

<template>
  <nav class="flex-1 py-2 overflow-y-auto " aria-label="Sidebar">
    <div class="flex flex-col divide-y divide-primary-800">
      <div class="px-2 py-6 space-y-1">
        <JLink
          v-for="item in adminItems" :key="item.name" :href="item.href"
          :active="$page.url === item.href"
          active-class="bg-primary-800 text-white"
          class="flex items-center px-2 py-2 text-sm font-medium leading-6 rounded-md group text-primary-100 hover:text-white hover:bg-primary-600"
        >
          <component :is="item.icon" size="24" class="flex-shrink-0 mr-4 text-primary-200" aria-hidden="true" />
          {{ item.name }}
        </JLink>
      </div>

      <div class="px-2 py-6 space-y-1">
        <JLink
          v-for="item in miscItems" :key="item.name" :href="item.href"
          :active="$page.url === item.href"
          active-class="bg-primary-800 text-white"
          class="flex items-center px-2 py-2 text-sm font-medium leading-6 rounded-md group text-primary-100 hover:text-white hover:bg-primary-600"
        >
          <component :is="item.icon" size="24" class="flex-shrink-0 mr-4 text-primary-200" aria-hidden="true" />
          {{ item.name }}
        </JLink>
      </div>
    </div>

    <footer class="absolute inset-x-0 bottom-0 cursor-pointer ">
      <div class="px-4 py-4 pb-3">
        <div class="text-xs font-medium text-white">
          All rights reserved
          © 2022-2023
        </div>
        <div class="text-xs text-primary-300 flex space-x-2 items-center">
          <span>
            App version 0.2.0
          </span>
          <emojione-v1-rocket size="16" />
        </div>
      </div>
    </footer>
  </nav>
</template>
