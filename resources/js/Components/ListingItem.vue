<script setup>
import { useWindowSize } from "@vueuse/core";

defineProps({
    listing: Object,
});

const { width } = useWindowSize();
function truncateText(length, text) {
    return text.length <= length ? text : `${text.slice(0, length)}...`;
}
</script>

<template>
    <div class="group">
        <div
            class="h-[225px] max-w-full overflow-hidden rounded-md lg:h-[260px] lg:w-[270px]"
        >
            <img
                :src="listing.images[0].url"
                :alt="listing.images[0].url"
                class="h-full w-full object-cover object-center transition-all duration-300 ease-in-out md:group-hover:scale-105 md:group-hover:opacity-75"
            />
        </div>
        <div class="mt-2 flex justify-between">
            <div class="pl-1">
                <h3 class="text-sm font-semibold text-gray-700">
                    <Link
                        :href="route('listings.show', listing.id)"
                    >
                        <span aria-hidden="true" class="absolute inset-0" />
                        {{ truncateText(width < 768 ? 23 : 30, listing.title) }}
                    </Link>
                </h3>
                <p class="mt-1 text-sm text-gray-500">{{ listing.artist }}</p>
                <p class="mt-1 text-sm font-semibold text-gray-900">
                    ${{ Math.round(listing.price).toString() }}
                </p>
            </div>
        </div>
    </div>
</template>
