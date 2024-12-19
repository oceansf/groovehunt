<script setup>
import { ref, computed } from "vue";
import ListingItem from "@/Components/ListingItem.vue";
import useInifiniteScroll from "@/composables/useInfiniteScroll";

const props = defineProps({
    listings: {
        type: Object,
        required: true,
    },
});

const landmark = ref(null);
const isSearchResults = computed(() => Array.isArray(props.listings));

// Only use infinite scroll for paginated results, not search results
const { items } = !isSearchResults.value 
    ? useInifiniteScroll("listings", landmark)
    : { items: ref(props.listings) };

</script>

<template>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl lg:max-w-6xl">
            <div class="mt-2 grid grid-cols-2 gap-x-1 gap-y-8 lg:grid-cols-4">
                <div
                    v-for="listing in isSearchResults ? listings : items"
                    :key="listing.id"
                    class="group relative"
                >
                    <ListingItem :listing="listing" />
                </div>
            </div>
        </div>
    </div>
    <div ref="landmark" v-if="!isSearchResults"></div>
</template>