<!-- ScrollToTop.vue -->
<script setup>
import { ref, computed } from "vue";
import { useWindowScroll } from "@vueuse/core";
import { ChevronUpIcon } from "@heroicons/vue/24/solid";

const { y } = useWindowScroll();

const showButton = computed(() => y.value > 300);

const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
};
</script>

<template>
    <Transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="translate-y-10 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-10 opacity-0"
    >
        <button
            v-show="showButton"
            @click="scrollToTop"
            class="fixed bottom-6 right-6 flex h-12 w-12 items-center justify-center rounded-full bg-black/80 text-white shadow-lg transition hover:bg-black focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
            aria-label="Scroll to top"
        >
            <ChevronUpIcon class="h-6 w-6" />
        </button>
    </Transition>
</template>
