<script setup>
import ListingItem from "@/Components/ListingGridItem.vue";

const props = defineProps({
    listings: {
        type: Object,
        required: true,
    },
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
                    v-for="listing in listings.data"
                    :key="listing.id"
                    class="group relative"
                >
                    <ListingItem :listing="listing" />
                </div>
            </div>
        </div>
    </div>
    <!-- <div ref="landmark"></div> -->
</template>
