<script setup lang="ts">
const { signIn } = useUser()
</script>

<template>
  <button @click="signIn('google')">
    Login with Google
  </button>
</template>
