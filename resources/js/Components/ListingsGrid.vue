<script setup>
import {listingsData} from '../../mockListings.js';
import ListingItem from "@/Components/ListingItem.vue";

const listings = listingsData.listings

</script>

<template>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl lg:max-w-6xl">
            <!-- <h2 class="text-3xl px-3 lg:px-0 font-bold tracking-tight text-gray-900">Market</h2>
            <div class="mt-4 flex justify-between">
                <button type="button" class="inline-flex items-center gap-x-1.5 rounded-md px-2.5 py-1.5 text-sm font-semibold text-slate-600 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                    </svg>
                    Filter
                </button>
                <button type="button" class="inline-flex items-center gap-x-1.5 rounded-md px-2.5 py-1.5 text-sm font-semibold text-slate-600 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0-3.75-3.75M17.25 21 21 17.25" />
                    </svg>
                    Sort
                </button>
            </div> -->
            <!--Listings Grid-->
            <div class="mt-2 grid grid-cols-2 gap-x-1 gap-y-8 lg:grid-cols-4 ">
                <div v-for="listing in listings" :key="listing.id" class="group relative">
                    <ListingItem :listing="listing" />
                </div>
            </div>
        </div>
    </div>
</template>