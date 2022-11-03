<script setup lang='ts'>
interface Props {
  height?: string
}
withDefaults(defineProps<Props>(), {
  height: 'h-0.5',
})

const baseClasses = 'bg-primary-100 relative top-0 left-0 w-full overflow-hidden j-progress'
</script>

<template>
  <div :class="[baseClasses, height]">
    <div :class="height" class="absolute bg-primary-500 j-progress increase" />
    <div :class="height" class="absolute bg-primary-500 j-progress decrease" />
  </div>
</template>

<style scoped>
.increase.j-progress {
  animation: j-progress-increase 2s ease-in-out infinite;
}

.decrease.j-progress {
  animation: j-progress-decrease 2s 0.9s ease-in-out infinite;
}

@keyframes j-progress-decrease {
  0% {
    left: -90%;
    width: 90%;
  }

  100% {
    left: 110%;
    width: 10%;
  }
}

@keyframes j-progress-increase {
  0% {
    left: -5%;
    width: 5%;
  }

  100% {
    left: 130%;
    width: 150%;
  }
}
</style>
