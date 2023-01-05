<script setup lang="ts">
const props = defineProps<{
  stats: {
    name: string
    stat: number
    previousStat: number
    change: number
    changeType: 'increase' | 'decrease'
  }[]
}>()
</script>

<template>
  <div>
    <h3 class="text-lg font-medium leading-6 text-gray-900">
      Last 30 days
    </h3>
    <dl
      class="grid grid-cols-1 mt-5 overflow-hidden bg-white divide-y divide-gray-200 rounded-lg shadow md:grid-cols-3 md:divide-y-0 md:divide-x"
    >
      <div v-for="product in stats" :key="product.name" class="px-4 py-5 sm:p-6">
        <dt class="text-base font-normal text-gray-900">
          {{ product.name }}
        </dt>
        <dd class="flex items-baseline justify-between mt-1 md:block lg:flex">
          <div class="flex items-baseline text-2xl font-semibold text-primary-600">
            {{ product.stat }}
            <span class="ml-2 text-sm font-medium text-gray-500">from {{ product.previousStat }}</span>
          </div>

          <div
            class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium md:mt-2 lg:mt-0"
            :class="[product.changeType === 'increase' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800']"
          >
            <heroicons-arrow-up
              v-if="product.changeType === 'increase'"
              class="-ml-1 mr-0.5 h-5 w-5 flex-shrink-0 self-center text-green-500" aria-hidden="true"
            />
            <heroicons-arrow-down
              v-else class="-ml-1 mr-0.5 h-5 w-5 flex-shrink-0 self-center text-red-500"
              aria-hidden="true"
            />
            <span class="sr-only"> {{ product.changeType === 'increase' ? 'Increased' : 'Decreased' }} by
            </span>
            {{ product.change }}
          </div>
        </dd>
      </div>
    </dl>
  </div>
</template>
