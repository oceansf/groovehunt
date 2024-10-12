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
    <div class="h-[225px] max-w-full lg:h-[300px] lg:w-[300px] overflow-hidden bg-gray-200 group-hover:opacity-75">
        <img :src="listing.images[0]" :alt="listing.images[0]" class="rounded-md h-full w-full object-cover object-center lg:h-full lg:w-full" />
    </div>
    <div class="mt-2 flex justify-between">
        <div class="pl-1">
            <h3 class="text-sm lg:text-base text-gray-700 font-bold">
                <a :href="listing.images[0]">
                    <span aria-hidden="true" class="absolute inset-0" />
                    {{ truncateText(width < 768 ? 23 : 33, listing.title) }}
                </a>
            </h3>
            <p class="mt-1 text-sm lg:text-base text-gray-500">{{ listing.artist }}</p>
            <p class="mt-1 text-sm lg:text-base font-bold text-gray-900">${{ Math.ceil(listing.price).toString() }}</p>
        </div>
    </div>
</template>
