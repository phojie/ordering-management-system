<script setup lang="ts">
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'

const sidebar = useSidebarStore()
</script>

<template>
  <TransitionRoot as="template" :show="sidebar.state">
    <Dialog as="div" class="relative z-40 lg:hidden" @close="sidebar.close()">
      <TransitionChild
        as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
        enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" />
      </TransitionChild>

      <div class="fixed inset-0 z-40 flex">
        <TransitionChild
          as="template" enter="transition ease-in-out duration-300 transform"
          enter-from="-translate-x-full" enter-to="translate-x-0"
          leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
          leave-to="-translate-x-full"
        >
          <DialogPanel
            class="relative flex flex-col flex-1 w-full max-w-xs pt-5 pb-16 bg-gradient-to-b from-primary-700 via-primary-700 to-primary-900"
          >
            <TransitionChild
              as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
              enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100"
              leave-to="opacity-0"
            >
              <div class="absolute top-0 right-0 pt-2 -mr-12">
                <button
                  type="button"
                  class="flex items-center justify-center w-10 h-10 ml-1 rounded-full focus:outline-none"
                  @click="sidebar.close()"
                >
                  <span class="sr-only">Close sidebar</span>
                  <heroicons-x-mark class="w-6 h-6 text-gray-50" aria-hidden="true" />
                </button>
              </div>
            </TransitionChild>

            <div class="flex items-center flex-shrink-0 px-4">
              <JLink :to="route('index')">
                <AppIcon class="w-auto h-24" />
              </JLink>
            </div>

            <div class="flex flex-1 h-0 overflow-y-auto">
              <!-- Navigation -->
              <AdminNavigation />
            </div>
          </DialogPanel>
        </TransitionChild>

        <div class="flex-shrink-0 w-14" aria-hidden="true">
          <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
      </div>
    </Dialog>
  </TransitionRoot>

  <div
    class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col lg:border-r border-primary-800 bg-gradient-to-b from-primary-700 via-primary-700 to-primary-900 lg:pt-5 lg:pb-16"
  >
    <div class="flex items-center flex-shrink-0 px-4">
      <JLink :to="route('index')">
        <AppIcon class="w-auto h-20" />
      </JLink>
    </div>

    <div class="flex flex-col flex-1 h-0 overflow-y-auto">
      <!-- Navigation -->
      <AdminNavigation />
    </div>
  </div>
</template>
