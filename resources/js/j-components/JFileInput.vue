<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-expect-error
import { setOptions } from 'vue-filepond'

interface FileInput {
  modelValue: any
  label?: string
  id?: string
  acceptedFileTypes?: 'image/*' | 'application/pdf' | 'application/*'
  allowMultiple?: boolean
}

const props = withDefaults(defineProps<FileInput>(), {
  // defaults
  // allowMultiple: true,
})

// set emits
const emit = defineEmits(['update:modelValue'])

// set refs
const pond = ref<any>(null)
const files = ref<any>(props.modelValue)

const allowFilePoster = computed(() => {
  return props.modelValue !== null || props.modelValue !== undefined || props.modelValue !== ''
})

function handleFilePondInit() {
  setOptions({
    allowFilePoster: !allowFilePoster.value,
    server: {
      process: {
        url: route('components.upload.store'),
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': usePage().props.value?.csrfToken,
        },
      },
    },
    files: !allowFilePoster.value ? [props.modelValue] : [],
  })
}

function handleProcessFile() {
  const serverId = pond.value?.getFile().serverId?.replace(/"/g, '')
  emit('update:modelValue', serverId)
}

function handleRemoveFile() {
  emit('update:modelValue', '')
}
</script>

<template>
  <div>
    <label
      v-if="props.label"
      :for="id"
      class="block mb-1 text-sm font-medium text-gray-900"
    >
      {{ label }}
    </label>

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
      @init="handleFilePondInit"
    />
  </div>
</template>
