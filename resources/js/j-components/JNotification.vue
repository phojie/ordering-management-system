<script setup lang="ts">
import type { Notification } from './types'
import HeroiconsInformationCircle from '~icons/heroicons/information-circle'
import HeroiconsExclamationCircle from '~icons/heroicons/exclamation-circle'
import HeroiconsExclamationTriangle from '~icons/heroicons/exclamation-triangle'
import HeroiconsCheckCircle from '~icons/heroicons/check-circle'
import HeroiconsTrash from '~icons/heroicons/trash'
import HeroiconsArrowPathRoundedSquare from '~icons/heroicons/arrow-path-rounded-square'

const props = withDefaults(defineProps<Notification>(), {
  duration: 4,
  showClose: true,
  showIcon: true,
  variant: 'info',
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
  if (props.icon) {
    switch (props.icon) {
      case 'check':
        return HeroiconsCheckCircle
      case 'warning':
        return HeroiconsExclamationTriangle
      case 'error':
        return HeroiconsExclamationCircle
      case 'trash':
        return HeroiconsTrash
      case 'restore':
        return HeroiconsArrowPathRoundedSquare
      default:
        return HeroiconsInformationCircle
    }
  }
  else {
    switch (props.variant) {
      case 'success':
        return HeroiconsCheckCircle
      case 'warning':
        return HeroiconsExclamationTriangle
      case 'danger':
        return HeroiconsExclamationCircle
      default:
        return HeroiconsInformationCircle
    }
  }
})

const iconColor = computed(() => {
  switch (props.variant) {
    case 'success':
      return 'text-success-500 bg-success-500'
    case 'warning':
      return 'text-warning-500 bg-warning-500'
    case 'danger':
      return 'text-danger-500 bg-danger-500'
    default:
      return 'text-info-500 bg-info-500'
  }
})

const iconClass = computed(() => {
  return `${iconColor.value} w-7 h-7 p-1 rounded-full bg-opacity-10`
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
            <div v-if="props.actions?.length as any > 0" class="flex mt-3 space-x-7">
              <!-- action buttons -->
              <JLink
                v-for="(action, i) in props.actions"
                :key="i"
                :to="action.url"
                as="button"
                :data="action.data"
                :method="action.method"
                class="text-sm font-medium bg-white rounded-md text-primary-600 hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                @click.once="close"
              >
                {{ action.label ?? 'Undo' }}
              </JLink>

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
