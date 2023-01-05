<script setup lang="ts">
const menuForm = useMenuStore().menuForm
const $v = useMenuStore().vuelidate
</script>

<template>
  <div class="pt-6 pb-5 space-y-6">
    <JTextField
      id="name"
      v-model="menuForm.name"
      placeholder="Name"
      :error-message="$v.name.$errors[0]?.$message as string"
      :is-dirty="$v.name.$error"
      label="Name"
    />
    <JTextField
      id="description"
      v-model="menuForm.description"
      label="Description"
      error-message="Description is required"
      :is-dirty="$v.description.$error"
    />

    <div>
      <h3 class="text-sm font-medium text-gray-900">
        Menu Products
      </h3>
      <div class="mt-2" />
    </div>

    <fieldset v-if="false">
      <legend class="text-sm font-medium text-gray-900">
        Status
      </legend>
      <div class="mt-2 space-y-5">
        <div class="relative flex items-start">
          <div class="absolute flex items-center h-5">
            <input
              id="privacy-public"
              name="privacy"
              aria-describedby="privacy-public-description"
              type="radio"
              class="w-4 h-4 border-gray-300 text-primary-600 focus:ring-primary-500"
              checked="true"
            >
          </div>
          <div class="text-sm pl-7">
            <label for="privacy-public" class="font-medium text-gray-900">Available</label>
            <p id="privacy-public-description" class="text-gray-500">
              Everyone can order this menu.
            </p>
          </div>
        </div>
        <div>
          <div class="relative flex items-start">
            <div class="absolute flex items-center h-5">
              <input
                id="privacy-private-to-menu"
                name="privacy"
                aria-describedby="privacy-private-to-menu-description"
                type="radio"
                class="w-4 h-4 border-gray-300 text-primary-600 focus:ring-primary-500"
              >
            </div>
            <div class="text-sm pl-7">
              <label for="privacy-private-to-menu" class="font-medium text-gray-900">For dining only</label>
              <p id="privacy-private-to-menu-description" class="text-gray-500">
                Only customers who are dining in can order this menu.
              </p>
            </div>
          </div>
        </div>
        <div>
          <div class="relative flex items-start">
            <div class="absolute flex items-center h-5">
              <input
                id="privacy-private"
                name="privacy"
                aria-describedby="privacy-private-to-menu-description"
                type="radio"
                class="w-4 h-4 border-gray-300 text-primary-600 focus:ring-primary-500"
              >
            </div>
            <div class="text-sm pl-7">
              <label for="privacy-private" class="font-medium text-gray-900">For take out only
              </label>
              <p id="privacy-private-description" class="text-gray-500">
                You are the only one able to access this menu.
              </p>
            </div>
          </div>
        </div>
      </div>
    </fieldset>
  </div>
</template>
