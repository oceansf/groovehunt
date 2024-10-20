<script setup>
import { computed } from "vue";

const { size } = defineProps({
    size: String,
});

const imgClass = computed(() => {
    switch (size) {
        case "sm":
            return "h-8 w-auto";
        case "md":
            return "h-12 w-auto";
        case "lg":
            return "h-16 w-auto";
        default:
            return '';
    }
});

const spanClass = computed(() => {
    switch (size) {
        case "sm":
            return "hidden text-xl";
        case "md":
            return "text-2xl";
        case "lg":
            return "text-4xl text-black";
        default:
            return "";
    }
});
</script>

<template>
    <Link href="/" class="flex flex-shrink-0 items-center justify-center gap-2">
        <img
            :class="imgClass"
            src="https://res.cloudinary.com/oceansf/image/upload/v1728751022/vinyl-logo_zmvc9b.png"
            alt="Groove Hunt"
        />
        <span
            :class="[
                spanClass,
                `font-['Helvetica'] font-bold tracking-tight text-black md:block`,
            ]"
            >groovehunt</span
        >
    </Link>
</template>