<script setup lang="ts">
import ApplicationLogo from "@/Components/breeze/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import LogoLink from "@/Components/LogoLink.vue";
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-900 pt-6 sm:justify-center sm:pt-0"
    >
        <div
            class="mt-6 w-full overflow-hidden bg-white px-10 py-12 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <div class="mb-12">
                <LogoLink size="lg" />
            </div>
            <slot />
        </div>
    </div>
</template>
