<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import { useIntersectionObserver } from "@vueuse/core";
import ListingItem from "@/Components/ListingGridItem.vue";

const props = defineProps({
    listings: {
        type: Object,
        required: true,
    },
});

// Local reactive state
const localListings = ref({
    data: [...props.listings.data],
    meta: { ...props.listings.meta },
    path: props.listings.path,
    next_cursor: props.listings.next_cursor,
    total: props.listings.total,
});

const bottom = ref(null);
const loading = ref(false);

onMounted(() => {
    console.log("Initial props:", props.listings);
});

useIntersectionObserver(bottom, ([{ isIntersecting }]) => {
    console.log("Intersection detected:", isIntersecting);
    console.log("Current next_cursor:", localListings.value.next_cursor);

    if (!isIntersecting || !localListings.value.next_cursor || loading.value) {
        return;
    }

    loading.value = true;
    console.log(
        "Making API call to:",
        `${localListings.value.path}?cursor=${localListings.value.next_cursor}`,
    );

    axios
        .get(
            `${localListings.value.path}?cursor=${localListings.value.next_cursor}`,
        )
        .then((response) => {
            console.log("API Response:", response.data);
            localListings.value = {
                ...localListings.value,
                data: [...localListings.value.data, ...response.data.data],
                next_cursor: response.data.meta.next_cursor,
                meta: response.data.meta,
            };
        })
        .catch((error) => {
            console.error("API Error:", error);
        })
        .finally(() => {
            loading.value = false;
        });
});
</script>

<template>
    <div class="bg-slate-50">
        <h2 class="text-slate-500">
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
                    v-for="listing in loc.data"
                    :key="listing.id"
                    class="group relative"
                >
                    <ListingItem :listing="listing" />
                </div>
            </div>
        </div>
    </div>
    <div ref="bottom"></div>
</template>
