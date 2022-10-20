<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() => props.active
    ? '!text-white !bg-primary-800'
    : 'flex items-center px-2 py-2 text-sm font-medium leading-6 rounded-md group text-primary-100 hover:text-white hover:bg-primary-600'
);
</script>

<template>
    <Link :href="href" :class="classes">
    <slot />
    </Link>
</template>
