<script setup lang="ts">
interface FileInput {
  label?: string
  id?: string
}

const props = withDefaults(defineProps<FileInput>(), {
  // defaults
})

const myFiles = ref(['cat.jpeg'])
function handleFilePondInit() {
  console.log('FilePond has initialized')
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
      :allow-multiple="true"
      accepted-file-types="image/jpeg, image/png"
      server="/api"
      :files="myFiles"
      @init="handleFilePondInit"
    />
  </div>
</template>
