<script setup>
defineProps({
    type: String,
    options: Array,
});
</script>

<template>
    <select
        class="hover:cursor-pointer mt-1 block w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
    >
        <option selected disabled hidden value="">Select a {{ type }}</option>
        <option v-for="option in options" :value="option.value">{{ option.label }}</option>
    </select>
</template>
