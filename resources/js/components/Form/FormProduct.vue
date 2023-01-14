<script setup lang="ts">
const { form, $v } = useProductStore()
const processing = $computed(() => useProductStore().processing)
</script>

<template>
  <div class="pt-6 pb-5 space-y-6">
    <JFileInput
      v-model="form.image"
      label="Product Image"
    />

    <JSelect
      v-model="form.status"
      label="Status"
      :items="['active', 'inactive']"
      :is-disabled="processing"
      default-value="active"
    />

    <InputCategories v-model="form.categories" />

    <JTextField
      id="name"
      v-model="form.name"
      placeholder="Name"
      label="Name"
      :is-disabled="processing"
      :error-message="$v.name.$errors[0]?.$message"
      :is-error="$v.name.$error"
    />

    <JTextArea
      id="description"
      v-model="form.description"
      placeholder="Short description"
      label="Description"
      :is-disabled="processing"
      :error-message="$v.description.$errors[0]?.$message"
      :is-error="$v.description.$error"
    />

    <FormVariant />
  </div>
</template>
