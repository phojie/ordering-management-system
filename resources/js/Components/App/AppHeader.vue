<script setup lang="ts">
const auth = useAuthStore()
</script>

<template>
  <div class="flex items-center justify-center p-4 space-x-10">
    <!-- <NavLink v-if="!user" to="/login">
      Login form
    </NavLink>
    <NavLink to="/">
      Home
    </NavLink>
    <NavLink to="/random/">
      404
    </NavLink>

    <NavLink to="/cart/">
      Cart
    </NavLink>

    <NavLink v-if="user" to="/admin/">
      Admin
    </NavLink> -->

    <button v-if="auth.signedIn" type="button" @click="auth.signOut">
      Logout
    </button>

    <div>
      {{ auth.user?.email || 'No user signIn' }}
    </div>
  </div>
</template>
