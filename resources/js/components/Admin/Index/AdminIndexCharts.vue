<script setup lang="ts">
const props = defineProps<{
  ordersProductQuantity: {
    categories: Array<any>
    series: Array<any>
  }
}>()
</script>

<template>
  <div>
    <h2 class="mb-5 text-lg font-medium leading-6 text-gray-900">
      Overview
    </h2>
    <div class="grid flex-1 grid-cols-1 gap-4 lg:grid-cols-12">
      <div class="col-span-1 p-2 bg-white rounded-lg shadow lg:col-span-5 ">
        <ChartBar title="Orders per product (Line)" type="line" :series="ordersProductQuantity.series" :categories="ordersProductQuantity.categories" />
      </div>
      <div class="col-span-1 p-2 bg-white rounded-lg shadow lg:col-span-7 ">
        <ChartBar title="Orders per product (Bar)" type="bar" :series="ordersProductQuantity.series" :categories="ordersProductQuantity.categories" />
      </div>
      <!-- <div class="col-span-1 p-2 bg-white rounded-lg shadow lg:col-span-4 min-h-[500px]">
        <ChartSpline />
      </div> -->
    </div>
  </div>
</template>
