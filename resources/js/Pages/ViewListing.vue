<script setup>
import { ref } from "vue";
import { Disc, Music, Album, Star} from "lucide-vue-next";
import { UserCircleIcon, StarIcon } from "@heroicons/vue/20/solid";
import Tracklist from "@/Components/Tracklist.vue";
import { listingsData } from "../../mockListings.js";

// Mock data for the listing
const listing = ref({
    title: "Original Pressing: Miles Davis - Kind of Blue",
    artist: "Miles Davis",
    price: 299.99,
    condition: "Near Mint",
    genre: "Jazz",
    releaseYear: 1959,
    format: "LP, Album, Mono",
    description:
        "Original 1959 mono pressing of Miles Davis' seminal album 'Kind of Blue'. This is a rare find in near mint condition. The vinyl shows minimal signs of play and the cover is in excellent condition with only slight wear on the edges. A must-have for any serious jazz collector.",
    images: [
        "https://res.cloudinary.com/oceansf/image/upload/v1728876609/hks5ddopfyhxjdw4gng1.webp",
        "https://res.cloudinary.com/oceansf/image/upload/v1728876609/knv7c27fchmibi4q7cuc.webp",
        "https://res.cloudinary.com/oceansf/image/upload/v1728876608/b1t9628ictltt8x7qxdy.webp",
        "https://res.cloudinary.com/oceansf/image/upload/v1728876609/wziomkl8z9h24t5tu5lf.webp",
        "https://res.cloudinary.com/oceansf/image/upload/v1728876609/jggjatnyalqzjd4gigbc.webp",
        "https://res.cloudinary.com/oceansf/image/upload/v1728876609/nsytezhib398ghwxgag3.webp",
    ],
    seller: {
        name: "VinylVault",
        avatar: "/placeholder.svg?height=100&width=100&text=VV",
        rating: 4.9,
        reviews: 382,
    },
});

const mockListings = listingsData.listings;

const currentImageIndex = ref(0);
</script>

<template>
    <div class="container mx-auto px-4 py-8 max-w-5xl h-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Image Gallery -->
            <div class="space-y-4">
                <div
                    class="aspect-square overflow-hidden rounded-lg bg-gray-100"
                >
                    <img
                        :src="listing.images[currentImageIndex]"
                        :alt="listing.title"
                        class="w-full h-full object-contain"
                    />
                </div>
                <div class="grid grid-cols-4 gap-4">
                    <button
                        v-for="(image, index) in listing.images"
                        :key="index"
                        @click="currentImageIndex = index"
                        class="aspect-square overflow-hidden rounded-md bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{
                            'ring-2 ring-blue-500': currentImageIndex === index,
                        }"
                    >
                        <img
                            :src="image"
                            :alt="`${listing.title} - Image ${index + 1}`"
                            class="w-full h-full object-cover"
                        />
                    </button>
                </div>
            </div>

            <!-- Listing Details -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold">{{ listing.title }}</h1>
                    <p class="text-xl text-gray-600">{{ listing.artist }}</p>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-3xl font-bold"
                        >${{ listing.price.toFixed(2) }}</span
                    >
                    <span
                        class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium"
                    >
                        {{ listing.condition }}
                    </span>
                </div>
                <div class="flex gap-2 items-center md:w-7/12">
                    <button
                        type="button"
                        class="flex-1 rounded-md bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600"
                    >
                        Buy Now
                    </button>
                    <button
                        type="button"
                        class="flex-1 rounded-md bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50"
                    >
                        Make Offer
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <Disc class="w-5 h-5 text-gray-500" />
                        <span>{{ listing.genre }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <Music class="w-5 h-5 text-gray-500" />
                        <span>{{ listing.releaseYear }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <Album class="w-5 h-5 text-gray-500" />
                        <span>{{ listing.format }}</span>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h2 class="text-xl font-semibold mb-2">Description</h2>
                    <p class="text-gray-600">{{ listing.description }}</p>
                </div>

                <div class="border-t pt-4">
                    <h2 class="text-xl font-semibold mb-2">Tracklist</h2>
                    <Tracklist />
                </div>

                <div class="border-t pt-4">
                    <h2 class="text-xl font-semibold mb-2">
                        Seller Information
                    </h2>
                    <div class="flex items-center space-x-4">
                        <UserCircleIcon class="w-12 h-12 rounded-full" />
                        <div>
                            <p class="font-medium">{{ listing.seller.name }}</p>
                            <div class="flex items-center">
                                <StarIcon class="w-4 h-4 text-yellow-400" />
                                <span class="ml-1"
                                    >{{ listing.seller.rating }} ({{ listing.seller.reviews }} reviews)</span
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="text-xl font-semibold">More from this seller</h2>
                <div class="grid grid-cols-4 gap-4">
                    <button
                        v-for="listing in mockListings"
                        :key="listing.title"
                        class="aspect-square overflow-hidden rounded-md bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <img
                            :src="listing.images[0]"
                            :alt="`${listing.title}`"
                            class="w-full h-full object-cover"
                        />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
