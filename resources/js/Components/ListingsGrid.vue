<script setup>
import {listingsData} from '../../mockListings.js';
import ListingItem from "@/Components/ListingItem.vue";

const listings = listingsData.listings

</script>

<template>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl lg:max-w-6xl">
            <!--Listings Grid-->
            <div class="mt-2 grid grid-cols-2 gap-x-1 gap-y-8 lg:grid-cols-4 ">
                <div v-for="listing in listings" :key="listing.id" class="group relative">
                    <ListingItem :listing="listing" />
                </div>
            </div>
        </div>
    </div>
</template>