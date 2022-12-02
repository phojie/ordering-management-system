<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-expect-error
import { setOptions } from 'vue-filepond'

interface FileInput {
  modelValue: any
  label?: string
  acceptedFileTypes?: 'image/*' | 'application/pdf' | 'application/*'
  allowMultiple?: boolean
}

const props = withDefaults(defineProps<FileInput>(), {
  // defaults
})

// set emits
const emit = defineEmits(['update:modelValue'])

// set refs
const pond = ref<any>(null)
const files = ref<any>(props.modelValue)

const emptyFiles = computed(() => {
  return props.modelValue === ''
})

function handleFilePondInit() {
  if (emptyFiles.value) {
    setOptions({
      allowFilePoster: false,
      files: [],
      server: {
        process: {
          url: route('components.upload.store'),
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': usePage().props.value?.csrfToken,
          },
        },
      },

    })
  }
  else {
    setOptions({
      allowFilePoster: true,
      files: [
        {
          source: props.modelValue,
          options: {
            type: 'local',
            metadata: {
              poster: props.modelValue,
            },
          },
        },
      ],
      server: {},
    })
  }
}

function handleProcessFile() {
  const serverId = pond.value?.getFile().serverId?.replace(/"/g, '')
  emit('update:modelValue', serverId)
}

function handleRemoveFile() {
  emit('update:modelValue', '')
  nextTick(() => {
    handleFilePondInit()
  })
}
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
    <FilePond
      ref="pond"
      name="filepond"
      class="rounded-lg group"
      label-idle="Drop image here or <span class='group-hover:underline'> Browse </span>"
      :allow-multiple="allowMultiple"
      :accepted-file-types="acceptedFileTypes"
      :files="files"
      @processfile="handleProcessFile"
      @removefile="handleRemoveFile"
      @init="handleFilePondInit()"
    />
  </div>
</template>
