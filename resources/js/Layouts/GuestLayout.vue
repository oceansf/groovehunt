<script setup lang="ts">
import ApplicationLogo from "@/Components/breeze/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-900 pt-6 sm:justify-center sm:pt-0"
    >
        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <div class="flex justify-center my-12">
                <Link href="/">
                    <!-- <ApplicationLogo class="h-20 w-20 fill-current text-gray-500" /> -->
                    <Link
                        href="/"
                        class="flex items-center gap-2"
                    >
                        
                            <img
                                class="h-12 w-auto"
                                src="https://res.cloudinary.com/oceansf/image/upload/v1728751022/vinyl-logo_zmvc9b.png"
                                alt="Groove Hunt"
                            />
                            <span
                                class="text-4xl text-black font-bold tracking-tight font-['Helvetica']"
                                >groovehunt</span
                            >
                        
                    </Link>
                </Link>
            </div>
            <slot />
        </div>
    </div>
</template>
