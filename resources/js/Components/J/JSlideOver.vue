<script setup lang="ts">
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'

const props = defineProps<{
  state?: boolean
  title: string
  description?: string
}>()

const emit = defineEmits<{
  (e: 'hide'): void
  (e: 'submit'): void
}>()
</script>

<template>
  <TransitionRoot as="template" :show="props.state">
    <Dialog as="div" class="relative z-10" @close="emit('hide')">
      <div class="fixed inset-0" />

      <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
          <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 pointer-events-none sm:pl-16">
            <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
              <DialogPanel class="w-screen max-w-md pointer-events-auto">
                <form class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl" @submit.prevent="emit('submit')">
                  <div class="flex-1 h-0 overflow-y-auto">
                    <div class="px-4 py-6 bg-primary-700 sm:px-6">
                      <div class="flex items-center justify-between">
                        <DialogTitle class="text-lg font-medium text-white">
                          {{ props.title }}
                        </DialogTitle>
                        <div class="flex items-center ml-3 h-7">
                          <button type="button" class="rounded-md text-primary-200 bg-primary-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white" @click="emit('hide')">
                            <span class="sr-only">Close panel</span>
                            <XMarkIcon class="w-6 h-6" aria-hidden="true" />
                          </button>
                        </div>
                      </div>
                      <div class="mt-1">
                        <p class="text-sm text-primary-300">
                          {{ props.description }}
                        </p>
                      </div>
                    </div>
                    <slot />
                  </div>
                  <div class="flex justify-end flex-shrink-0 px-4 py-4">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2" @click="emit('hide')">
                      Cancel
                    </button>
                    <button type="submit" class="inline-flex justify-center px-4 py-2 ml-4 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                      Save
                    </button>
                  </div>
                </form>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
