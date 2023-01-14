<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-expect-error
import { setOptions } from 'vue-filepond'

export interface Props {
  label?: string
  acceptedFileTypes?: Array<'image/*' | 'application/pdf' | 'application/*'>
  allowMultiple?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  // defaults
  acceptedFileTypes: () => ['image/*'],
})

// set model
const { modelValue } = defineModel<{
  modelValue: any
}>()

// set refs
const pond = ref<any>(null)
const files = ref<any>(modelValue.value)

const emptyFiles = computed(() => {
  return modelValue.value === ''
})

const serverId = () => {
  return pond.value?.getFile().serverId?.replace(/"/g, '') ?? ''
}

function handleFilePondInit() {
  if (emptyFiles.value)
    setServerProcess()

  else
    setServerFetch()
}

function setServerFetch() {
  setOptions({
    allowFilePoster: true,
    files: [
      {
        source: modelValue.value,
        options: {
          type: 'LOCAL',
          metadata: {
            poster: modelValue.value,
          },
        },
      },
    ],
    server: {
      fetch: (url: any, load: any, error: any) => {
        const request = new XMLHttpRequest()
        request.open('GET', url, true)
        request.responseType = 'blob'
        request.onload = () => {
          if (request.status >= 200 && request.status < 300)
            load(request.response)

          else
            error('oh no')
        }
        request.send()

        return {
          abort: () => {
            request.abort()
          },
        }
      },
    },
  })
}

function setServerProcess() {
  setOptions({
    allowFilePoster: false,
    files: [],
    server: {
      headers: {
        'X-CSRF-TOKEN': usePage().props.value?.csrfToken,
      },
      process: {
        url: route('components.temporary-file.store'),
      },
      revert: (uniqueFileId: any, load: any) => {
        useFetch(route('components.temporary-file.destroy', uniqueFileId.replace(/"/g, '')), {
          method: 'DELETE',
        }, {
          async beforeFetch({ options }) {
            options.headers = {
              ...options.headers,
              'X-CSRF-TOKEN': usePage().props.value?.csrfToken as string,
            }

            return {
              options,
            }
          },
        })
          .then(() => {
            load()
          })
      },
    },
  })
}

function handleProcessFile() {
  modelValue.value = serverId()
}

function handleRemoveFile() {
  nextTick(() => {
    setServerProcess()
    modelValue.value = ''
  })
}

// watch
watch(() => modelValue.value, (value) => {
  if (value === '')
    handleRemoveFile()
})
</script>

<template>
  <div>
    <!-- label -->
    <label
      v-if="props.label"
      class="block mb-1 text-sm font-medium text-gray-900"
    >
      {{ label }}
    </label>

    <!-- input wrapper -->
    <Suspense>
      <FilePond
        ref="pond"
        name="filepond"
        class="rounded-lg group"
        label-idle="Drop image here or <span class='group-hover:underline'> Browse </span>"
        :allow-multiple="allowMultiple"
        :files="files"
        :accepted-file-types="acceptedFileTypes"
        @processfile="handleProcessFile"
        @removefile="handleRemoveFile"
        @init="handleFilePondInit"
      />
    </Suspense>
  </div>
</template>
