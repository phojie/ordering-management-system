<script setup lang="ts">
import type { Notification } from './types'
import HeroiconsInformationCircle from '~icons/heroicons/information-circle'
import HeroiconsExclamationCircle from '~icons/heroicons/exclamation-circle'
import HeroiconsExclamationTriangle from '~icons/heroicons/exclamation-triangle'
import HeroiconsCheckCircle from '~icons/heroicons/check-circle'

const props = withDefaults(defineProps<Notification>(), {
  duration: 3,
  showClose: true,
  showIcon: true,
  showUndo: false,
  type: 'info',
})

const emit = defineEmits(['close'])

const close = () => {
  emit('close')
}

onMounted(() => {
  if (props.duration) {
    setTimeout(() => {
      close()
    }, props.duration * 1000)
  }
})

const icon = computed(() => {
  switch (props.type) {
    case 'success':
      return HeroiconsCheckCircle
    case 'warning':
      return HeroiconsExclamationTriangle
    case 'error':
      return HeroiconsExclamationCircle
    default:
      return HeroiconsInformationCircle
  }
})

const iconColor = computed(() => {
  switch (props.type) {
    case 'success':
      return 'text-success-500'
    case 'warning':
      return 'text-warning-500'
    case 'error':
      return 'text-danger-500'
    default:
      return 'text-info-500'
  }
})

const iconSize = computed(() => {
  return props.showIcon ? 'w-6 h-6' : 'w-0 h-0'
})

const iconClass = computed(() => {
  return `${iconColor.value} ${iconSize.value}`
})

// const notificationIconClass = computed(() => {
//   return `${iconClass.value} mr-4`
// })

// const notificationCloseIconClass = computed(() => {
//   return `${closeIconClass.value} ml-4`
// })

// const notificationTitleClass = computed(() => {
//   return 'text-sm font-medium text-gray-900'
// })

// const notificationMessageClass = computed(() => {
//   return 'text-sm text-gray-500'
// })

// const notificationCloseClass = computed(() => {
//   return 'flex-shrink-0 p-1 -mr-1 transition duration-150 ease-in-out rounded-full hover:bg-gray-100 focus:outline-none focus:bg-gray-100'
// })
</script>

<template>
  <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
  <transition
    enter-active-class="transition duration-300 ease-out transform"
    enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition duration-100 ease-in"
    leave-from-class="opacity-100" leave-to-class="opacity-0"
  >
    <div
      class="w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-lg pointer-events-auto ring-1 ring-black ring-opacity-5"
    >
      <div class="p-4">
        <div class="flex items-start">
          <div v-if="props.showIcon" class="flex-shrink-0">
            <component :is="icon" :class="iconClass" />
          </div>
          <div class="ml-3 w-0 flex-1 pt-0.5">
            <p v-if="props.title" class="text-sm font-medium text-gray-900">
              {{ props.title }}
            </p>
            <p v-if="props.message" class="mt-1 text-sm text-gray-500">
              {{ props.message }}
            </p>
            <div class="flex mt-3 space-x-7">
              <button
                v-if="props.showUndo"
                type="button"
                class="text-sm font-medium bg-white rounded-md text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
              >
                Undo
              </button>
              <button
                type="button"
                class="text-sm font-medium text-gray-700 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                @click="close"
              >
                Dismiss
              </button>
            </div>
          </div>
          <div v-if="props.showClose" class="flex flex-shrink-0 ml-4">
            <button
              type="button"
              class="inline-flex text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
              @click="close"
            >
              <heroicons-x-mark-20-solid class="w-5 h-5" aria-hidden="true" />
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>
