<script setup lang="ts">
import { LinkIcon, QuestionMarkCircleIcon } from '@heroicons/vue/20/solid'
const menuStore = useMenuStore()
</script>

<template>
  <JSlideOver
    title="New Menu"
    description="Create a new menu for your restaurant."
    @submit="menuStore.submitForm()"
  >
    <div class="flex flex-col justify-between flex-1">
      <div class="px-4 divide-y divide-gray-200 sm:px-6">
        <FormMenu />
        <div class="pt-4 pb-6">
          <div class="flex text-sm">
            <a href="#" class="inline-flex items-center font-medium text-primary-600 group hover:text-primary-900">
              <LinkIcon class="w-5 h-5 text-primary-500 group-hover:text-primary-900" aria-hidden="true" />
              <span class="ml-2">Copy link</span>
            </a>
          </div>
          <div class="flex mt-4 text-sm">
            <a href="#" class="inline-flex items-center text-gray-500 group hover:text-gray-900">
              <QuestionMarkCircleIcon class="w-5 h-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
              <span class="ml-2">Learn more about sharing</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </JSlideOver>
</template>
