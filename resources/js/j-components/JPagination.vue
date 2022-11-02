<script setup lang="ts">
</script>

<template>
  <nav class="flex items-center justify-between px-4 border-t border-gray-200 sm:px-0">
    <div class="flex flex-1 w-0 -mt-px">
      <a
        href="#"
        class="inline-flex items-center pt-4 pr-1 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700"
      >
        <heroicons-arrow-long-left-20-solid class="w-5 h-5 mr-3 text-gray-400" aria-hidden="true" />
        Previous
      </a>
    </div>
    <div class="hidden md:-mt-px md:flex">
      <a
        href="#"
        class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700"
      >1</a>
      <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
      <a
        href="#"
        class="inline-flex items-center px-4 pt-4 text-sm font-medium text-indigo-600 border-t-2 border-indigo-500"
        aria-current="page"
      >2</a>
      <a
        href="#"
        class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700"
      >3</a>
      <span
        class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent"
      >...</span>
      <a
        href="#"
        class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700"
      >8</a>
      <a
        href="#"
        class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700"
      >9</a>
      <a
        href="#"
        class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700"
      >10</a>
    </div>
    <div class="flex justify-end flex-1 w-0 -mt-px">
      <a
        href="#"
        class="inline-flex items-center pt-4 pl-1 text-sm font-medium text-gray-500 border-t-2 border-transparent hover:border-gray-300 hover:text-gray-700"
      >
        Next
        <heroicons-arrow-long-right-20-solid class="w-5 h-5 ml-3 text-gray-400" aria-hidden="true" />
      </a>
    </div>
  </nav>
</template>
