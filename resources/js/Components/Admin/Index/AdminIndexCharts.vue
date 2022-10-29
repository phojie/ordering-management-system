<script setup lang="ts">
</script>

<template>
  <div>
    <h2 class="mb-5 text-lg font-medium leading-6 text-gray-900">
      Overview
    </h2>
    <div class="grid flex-1 grid-cols-1 gap-4 lg:grid-cols-7">
      <div class="col-span-1 p-2 bg-white rounded-lg shadow lg:col-span-3 ">
        <ChartBar />
      </div>
      <div class="col-span-1 p-2 bg-white rounded-lg shadow lg:col-span-4 min-h-[500px]">
        <ChartSpline />
      </div>
    </div>
  </div>
</template>
