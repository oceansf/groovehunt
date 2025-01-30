<script setup>
import { ref, watch } from "vue";

const isLiked = ref(false);
const showMessage = ref(false);

defineProps({
    size: String,
});

const toggleLike = () => {
    isLiked.value = !isLiked.value;
    showMessage.value = true;
    setTimeout(() => {
        showMessage.value = false;
    }, 2000);
};

// Reset message when component is unmounted
watch(
    () => showMessage.value,
    (newValue) => {
        if (newValue) {
            const timer = setTimeout(() => {
                showMessage.value = false;
            }, 1500);

            return () => clearTimeout(timer);
        }
    },
);
</script>

<template>
    <div>
        <button
            @click="toggleLike"
            class="tooltip z-10 transform transition-transform duration-200 ease-in-out hover:scale-110 focus:outline-none active:scale-90"
            :data-tip="isLiked ? 'Remove from wishlist' : 'Add to wishlist'"
            :class="{ 'is-active': isLiked }"
            aria-label="Wishlist"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="transition-all duration-300 ease-in-out"
                :class="[
                    isLiked
                        ? 'animate-heart-burst text-red-500'
                        : 'text-gray-300',
                    size === 'lg' ? 'h-6 w-6' : 'h-4 w-4',
                ]"
            >
                <path
                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
                ></path>
            </svg>
        </button>

        <Teleport to="body">
            <Transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0"
            >
                <div
                    v-if="showMessage"
                    class="pointer-events-none fixed inset-0 z-50 flex items-center justify-center"
                >
                    <div
                        class="rounded-full bg-black/75 px-4 py-2 text-white shadow-lg"
                    >
                        {{ isLiked ? "Added to" : "Removed from" }} your
                        wishlist
                    </div>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>

<style scoped>
@keyframes heart-burst {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.3);
    }
    100% {
        transform: scale(1);
    }
}

.animate-heart-burst {
    animation: heart-burst 0.3s ease-out forwards;
}
</style>
