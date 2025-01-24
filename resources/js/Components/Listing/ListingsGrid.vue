<script setup>
import { ref } from "vue";
import axios from "axios";
import { useIntersectionObserver } from "@vueuse/core";
import ListingGridItem from "./ListingGridItem.vue";
import ScrollToTop from "../ScrollToTop.vue";

const props = defineProps({
    listings: {
        type: Object,
        required: true,
    },
});

const bottom = ref(null);

// Infinite scrolling
const { stop } = useIntersectionObserver(bottom, ([{ isIntersecting }]) => {
    if (!isIntersecting || !props.listings?.meta?.next_cursor) {
        return;
    }
    const serializableListings = JSON.parse(JSON.stringify(props.listings)); // added
    axios
        .get(
            `${props.listings.meta.path}?cursor=${props.listings.meta.next_cursor}`,
        )
        .then((response) => {
            props.listings.data = [
                ...serializableListings.data,
                ...response.data.data,
            ];

            props.listings.meta = response.data.meta;

            if (!props.listings.meta.next_cursor) {
                stop();
            }
        });
});
</script>

<template>
    <div>
        <h2 class="pl-4 sm:pl-2 text-slate-500">
            Showing {{ props.listings.total }}
            <span v-if="listings.total === 1">result</span
            ><span v-else>results</span>
        </h2>
        <div class="mx-auto max-w-2xl lg:max-w-6xl">
            <div v-if="listings.data.length === 0" class="mt-12 text-center">
                No listings found.
            </div>
            <div class="mt-2 grid grid-cols-2 gap-x-1 gap-y-8 lg:grid-cols-4">
                <div
                    v-for="listing in listings.data"
                    :key="listing.id"
                    class="group relative"
                >
                    <ListingGridItem :listing="listing" />
                </div>
            </div>
        </div>
    </div>
    <ScrollToTop />
    <div ref="bottom" class="-translate-y-32"></div>
</template>
