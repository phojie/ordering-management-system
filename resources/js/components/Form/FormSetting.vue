<script setup lang="ts">
const { form, $v, formState } = useSettingStore()
const processing = $computed(() => useSettingStore().processing)

// watch city, change postalCode base on city value
watch(() => form.city, (city) => {
  const address = _.find(useConstant().availableAddress, (address) => {
    return address.city === city
  }) as any

  form.postalCode = address?.postalCode
  form.province = address?.province
})
</script>

<template>
  <div class="pt-6 pb-5 space-y-6">
    <JFileInput
      v-if="formState.title === 'Update photo' || formState.title === 'Update profile'"
      v-model="form.avatar"
      label="Photo"
    />

    <JTextField
      v-if="formState.title === 'Update name' || formState.title === 'Update profile'"
      id="firstName"
      v-model="form.firstName"
      placeholder="John"
      label="First name"
      :is-disabled="processing"
      :error-message="$v.firstName.$errors[0]?.$message"
      :is-error="$v.firstName.$error"
    />

    <JTextField
      v-if="formState.title === 'Update name' || formState.title === 'Update profile'"
      id="middleName"
      v-model="form.middleName"
      placeholder=""
      label="Middle name"
      :is-disabled="processing"
      hints="Optional"
    />

    <JTextField
      v-if="formState.title === 'Update name' || formState.title === 'Update profile'"
      id="lastName"
      v-model="form.lastName"
      placeholder="Doe"
      label="Last name"
      :is-disabled="processing"
      :error-message="$v.lastName.$errors[0]?.$message"
      :is-error="$v.lastName.$error"
    />

    <JTextField
      v-if="formState.title === 'Update username' || formState.title === 'Update profile'"
      id="username"
      v-model="form.username"
      placeholder="Username"
      label="Username"
      :is-disabled="processing"
      :error-message="$v.username.$errors[0]?.$message"
      :is-error="$v.username.$error"
    />

    <JTextField
      v-if="formState.title === 'Update email' || formState.title === 'Update profile'"
      id="email"
      v-model="form.email"
      placeholder="Email address"
      label="Email"
      :is-disabled="processing"
      :error-message="$v.email.$errors[0]?.$message"
      :is-error="$v.email.$error"
    />

    <JTextField
      v-if="formState.title === 'Update phone' || formState.title === 'Update profile'"
      id="phone"
      v-model="form.phone"
      label="Phone number"
      placeholder="09xxxxxxxxxx"
      :is-disabled="processing"
      :error-message="$v.phone.$errors[0]?.$message"
      :is-error="$v.phone.$error"
    />

    <JTextField
      v-if="formState.title === 'Update address' || formState.title === 'Update profile'"
      id="address"
      v-model="form.address1"
      placeholder="1234 Main St, Brgy. 123"
      label="Address"
      :is-disabled="processing"
      :error-message="$v.address1.$errors[0]?.$message"
      :is-error="$v.address1.$error"
    />

    <JSelect
      v-if="formState.title === 'Update address' || formState.title === 'Update profile'"
      id="city"
      v-model="form.city"
      label="Municipality/City"
      :items="useConstant().cityOptions"
      :is-disabled="processing"
      :error-message="$v.city.$errors[0]?.$message"
      :is-error="$v.city.$error"
    />

    <JSelect
      v-if="formState.title === 'Update address' || formState.title === 'Update profile'"
      id="province"
      v-model="form.province"
      label="Province"
      :items="useConstant().provinceOptions"
      :is-disabled="processing"
      :error-message="$v.city.$errors[0]?.$message"
      :is-error="$v.city.$error"
    />

    <JTextField
      v-if="formState.title === 'Update address' || formState.title === 'Update profile'"
      id="postal-code"
      v-model="form.postalCode"
      is-read-only
      autocomplete="postal-code"
      :error-message="$v.postalCode.$errors[0]?.$message"
      :is-error="$v.postalCode.$error"
      label="Postal code"
    />
  </div>
</template>
