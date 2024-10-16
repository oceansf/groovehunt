<script setup>
import {useWindowSize} from "@vueuse/core";

defineProps({
   listing: Object
})

const { width } = useWindowSize();
function truncateText(length, text) {
    return text.length <= length ? text : `${text.slice(0, length)}...`;
}


</script>

<template>
    <div class="h-[225px] max-w-full lg:h-[260px] lg:w-[270px] overflow-hidden bg-gray-200 group-hover:opacity-75 transition-opacity">
        <img :src="listing.images[0]" :alt="listing.images[0]" class="rounded-md h-full w-full object-cover object-center" />
    </div>
    <div class="mt-2 flex justify-between">
        <div class="pl-1">
            <h3 class="text-sm text-gray-700 font-semibold">
                <Link href="/listings/1">
                    <span aria-hidden="true" class="absolute inset-0" />
                    {{ truncateText(width < 768 ? 23 : 30, listing.title) }}
                </Link>
            </h3>
            <p class="mt-1 text-sm text-gray-500">{{ listing.artist }}</p>
            <p class="mt-1 text-sm font-semibold text-gray-900">${{ Math.round(listing.price).toString() }}</p>
        </div>
    </div>
</template>
