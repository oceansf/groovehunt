<script setup>
defineProps({
    text: String,
    optional: Boolean
});
</script>

<template>
    <label class="block text-sm font-medium leading-6 text-gray-900"
        >{{ text }} <em v-if="optional" class="text-gray-400 font-normal ml-1">Optional</em></label
    >
</template>
