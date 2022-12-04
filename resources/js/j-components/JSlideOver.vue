<script setup lang="ts">
interface SlideOver {
  state?: boolean
  title: string
  description?: string
  type: 'create' | 'edit'
  isLoading?: boolean
  size?: 'xs' | 'sm' | 'md' | 'lg' | 'xl'
}

const props = withDefaults(defineProps<SlideOver>(), {
  type: 'create',
  size: 'sm',
})

const emit = defineEmits<{
  (e: 'hide'): void
  (e: 'submit'): void
}>()

const bgColorsLookup = {
  create: 'bg-primary-700',
  edit: 'bg-warning-700',
}

const sizeLookup = {
  xs: 'max-w-xs',
  sm: 'max-w-sm',
  md: 'max-w-md',
  lg: 'max-w-lg',
  xl: 'max-w-xl',
}
</script>

<template>
  <TransitionRoot as="template" :show="props.state">
    <Dialog as="div" class="relative z-10" @close="emit('hide')">
      <div class="fixed inset-0" />

      <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
          <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 pointer-events-none sm:pl-16">
            <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
              <DialogPanel :class="sizeLookup[props.size]" class="w-screen pointer-events-auto">
                <form class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl" @submit.prevent="emit('submit')">
                  <div class="flex-1 h-0 overflow-y-auto">
                    <div
                      :class="`${
                        bgColorsLookup[props.type]
                      } px-4 py-6 sm:px-6`"
                    >
                      <div class="flex items-center justify-between">
                        <DialogTitle class="text-lg font-medium text-white">
                          {{ props.title }}
                        </DialogTitle>
                        <div class="flex items-center ml-3 h-7">
                          <JBtn
                            :variant="props.type === 'create' ? 'primary' : 'warning'"
                            :class="`${
                              bgColorsLookup[props.type]
                            } `"
                            is-icon
                            @click="emit('hide')"
                          >
                            <heroicons-x-mark class="w-6 h-6" aria-hidden="true" />
                          </JBtn>
                        </div>
                      </div>
                      <div class="mt-1">
                        <p
                          :class="`text-sm ${props.type === 'create' ? 'text-primary-300' : 'text-warning-300'}`"
                        >
                          {{ props.description }}
                        </p>
                      </div>
                    </div>
                    <slot />
                  </div>
                  <div class="flex justify-end flex-shrink-0 px-4 py-4 space-x-4">
                    <JBtn variant="text" label="Cancel" @click="emit('hide')" />
                    <JBtn
                      :variant="props.type === 'create' ? 'primary' : 'warning'"
                      type="submit" :label="props.type === 'create' ? 'Create' : 'Update'"
                      :is-loading="isLoading"
                    />
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
