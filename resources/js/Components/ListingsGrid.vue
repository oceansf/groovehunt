<script setup>
import { ref } from "vue";
import ListingItem from "@/Components/ListingItem.vue";
import useInifiniteScroll from "@/composables/useInfiniteScroll";

const props = defineProps({
    listings: {
        type: Object,
        required: true,
    },
});

const landmark = ref(null);

const { items } = useInifiniteScroll("listings", landmark);
</script>

<template>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl lg:max-w-6xl">
            <div class="mt-2 grid grid-cols-2 gap-x-1 gap-y-8 lg:grid-cols-4">
                <div
                    v-for="listing in items"
                    :key="listing.id"
                    class="group relative"
                >
                    <ListingItem :listing="listing" />
                </div>
            </div>
        </div>
    </div>
    <div ref="landmark"></div>
</template>
