<script setup lang="ts">
import type { PaginationLink } from '@/global'

const props = defineProps<{
  links: Array<PaginationLink>
}>()

// filter out the first and last links
const urlLinks = computed(() => props.links.filter((link, index) => link.url !== null && index !== 0 && index !== props.links.length - 1))

// get the previous page number
const previousLink = computed(() => props.links[0])

// get the next page number
const nextLink = computed(() => props.links[props.links.length - 1])

// TODO: Add a way to state a loading
// const isLoading = $ref(false)
</script>

<template>
  <nav class="flex items-center justify-between px-4 border-t border-gray-200 sm:px-0">
    <div class="flex flex-1 w-0 -mt-px">
      <JLink
        :to="previousLink.url || '#'"
        class="inline-flex items-center pt-4 pr-1 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700"
      >
        <heroicons-arrow-long-left-20-solid class="w-5 h-5 mr-3 text-gray-400" aria-hidden="true" />
        Previous
      </JLink>
    </div>
    <div class="hidden md:-mt-px md:flex">
      <JLink
        v-for="(link, key) in urlLinks"
        :key="key"
        :to="link.url || '#'"
        :active="link.active"
        class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700"
        active-class="inline-flex items-center px-4 pt-4 text-sm font-medium text-primary-600 border-t-2 border-primary-500"
      >
        {{ link.label }}
      </JLink>
    </div>
    <div class="flex justify-end flex-1 w-0 -mt-px">
      <JLink
        :to="nextLink.url || '#'"
        class="inline-flex items-center pt-4 pl-1 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700"
      >
        Next
        <heroicons-arrow-long-right-20-solid class="w-5 h-5 ml-3 text-gray-400" aria-hidden="true" />
      </JLink>
    </div>
  </nav>
</template>
