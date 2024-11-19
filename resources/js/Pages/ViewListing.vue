<script setup>
import { ref } from "vue";
import {
    CalendarIcon,
    Disc3Icon,
    DiscAlbumIcon,
    BuildingIcon,
    GlobeIcon,
    MusicIcon,
    HashIcon,
    SparklesIcon,
    CircleGaugeIcon,
    PaletteIcon,
    TruckIcon,
} from "lucide-vue-next";
import { UserCircleIcon, StarIcon } from "@heroicons/vue/20/solid";
import Tracklist from "@/Components/Tracklist.vue";
import Modal from "@/Components/MessageModal.vue";
import { listingsData } from "../Shared/mockListings.js";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

dayjs.extend(relativeTime);

defineProps({
    listing: Object,
});

// Remove this line when using real data
const mockListings = listingsData.listings;

const currentImageIndex = ref(0);

const showMessageModal = ref(false);
const messageForm = ref({
    name: "",
    email: "",
    message: "",
});

const openMessageModal = () => {
    showMessageModal.value = true;
};

const closeMessageModal = () => {
    showMessageModal.value = false;
    // Reset form fields
    messageForm.value = { name: "", email: "", message: "" };
};

// Function to format the date
const formatRelativeTime = (date) => {
    return dayjs(date).fromNow();
};

const sendMessage = () => {
    // Here you would typically send the message to your backend
    console.log("Sending message:", messageForm.value);
    // Close the modal after sending
    closeMessageModal();
};

const handleOutsideClick = (event) => {
    if (event.target === event.currentTarget) {
        closeMessageModal();
    }
};
</script>

<template>
    <div class="container mx-auto h-full max-w-5xl px-4 py-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <!-- Image Gallery -->
            <div class="space-y-4">
                <div
                    class="aspect-square overflow-hidden rounded-lg bg-gray-100"
                >
                    <img
                        :src="listing.images[currentImageIndex]"
                        :alt="listing.title"
                        class="h-full w-full object-contain"
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
                            class="h-full w-full object-cover"
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
                    <div class="flex flex-col">
                        <span class="text-3xl font-bold"
                            >${{ listing.price.toFixed(2) }}</span
                        >
                        <div class="flex items-center space-x-2 text-gray-600">
                            <em
                                >Shipping: ${{
                                    listing.shipping.toFixed(2)
                                }}</em
                            >
                        </div>
                    </div>
                    <span
                        class="rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800"
                    >
                        {{ listing.media_condition }}
                    </span>
                </div>
                <div class="space-y-2 md:w-9/12">
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            class="flex-1 rounded-md bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600"
                        >
                            Buy Now
                        </button>
                        <button
                            v-if="listing.allow_offers"
                            type="button"
                            class="flex-1 rounded-md bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50"
                        >
                            Make Offer
                        </button>
                        <button
                            v-else
                            type="button"
                            class="flex-1 cursor-not-allowed rounded-md bg-gray-200 px-6 py-3 text-sm font-semibold text-gray-500 shadow-sm ring-1 ring-inset ring-gray-300"
                            disabled
                        >
                            Make Offer
                        </button>
                    </div>
                    <button
                        type="button"
                        class="w-full rounded-md bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50"
                        @click="openMessageModal"
                    >
                        Message Seller
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <TruckIcon class="h-5 w-5 text-gray-500" />
                        <span>Ships from: United States</span>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h2 class="mb-2 text-xl font-semibold">Description</h2>
                    <p class="text-gray-600">{{ listing.description }}</p>
                </div>

                <div class="border-t pt-4">
                    <h2 class="mb-2 text-xl font-semibold">Tracklist</h2>
                    <Tracklist />
                </div>

                <div class="border-t pt-4">
                    <h3 class="mb-2 text-lg font-semibold">Listing Details</h3>
                </div>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <div class="space-y-4">
                            <p class="flex items-center">
                                <Disc3Icon class="mr-2 h-4 w-4 text-gray-500" />
                                Format:
                                {{ listing.format }}
                            </p>
                            <p class="flex items-center">
                                <SparklesIcon
                                    class="mr-2 h-4 w-4 text-gray-500"
                                />
                                Media condition: {{ listing.media_condition }}
                            </p>
                            <p class="flex items-center">
                                <DiscAlbumIcon
                                    class="mr-2 h-4 w-4 text-gray-500"
                                />
                                Sleeve condition: {{ listing.sleeve_condition }}
                            </p>
                            <p class="flex items-center">
                                <MusicIcon class="mr-2 h-4 w-4 text-gray-500" />
                                Genre:
                                {{ listing.genre }}
                            </p>
                            <p class="flex items-center">
                                <CircleGaugeIcon
                                    class="mr-2 h-4 w-4 text-gray-500"
                                />
                                Speed:
                                {{ listing.speed }}
                            </p>
                            <p class="flex items-center">
                                <PaletteIcon
                                    class="mr-2 h-4 w-4 text-gray-500"
                                />
                                Color:
                                {{ listing.color }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="space-y-4">
                            <p class="flex items-center">
                                <GlobeIcon class="mr-2 h-4 w-4 text-gray-500" />
                                Country:
                                {{ listing.release_country }}
                            </p>
                            <p class="flex items-center">
                                <CalendarIcon
                                    class="mr-2 h-4 w-4 text-gray-500"
                                />
                                Year:
                                {{ listing.release_year }}
                            </p>
                            <p class="flex items-center">
                                <BuildingIcon
                                    class="mr-2 h-4 w-4 text-gray-500"
                                />
                                Record label:
                                {{ listing.release_label }}
                            </p>
                            <p class="flex items-center">
                                <HashIcon class="mr-2 h-4 w-4 text-gray-500" />
                                Catalog number: {{ listing.release_cat_no }}
                            </p>
                            <p class="flex items-center">
                                <HashIcon class="mr-2 h-4 w-4 text-gray-500" />
                                Matrix number:
                                {{ listing.release_matrix_no }}
                            </p>
                            <p class="flex items-center">
                                <HashIcon class="mr-2 h-4 w-4 text-gray-500" />
                                UPC:
                                {{ listing.release_upc }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h2 class="mb-2 text-xl font-semibold">
                        Seller Information
                    </h2>
                    <div class="flex items-center space-x-1">
                        <UserCircleIcon
                            class="h-12 w-12 rounded-full text-gray-300"
                        />
                        <div>
                            <p class="font-medium">VinylVault</p>
                            <div class="flex items-center">
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <span class="pl-1">4.9 (382 reviews)</span>
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
                            class="h-full w-full object-cover"
                        />
                    </button>
                </div>
            </div>
        </div>
    </div>

    <Modal
        :showMessageModal="showMessageModal"
        :messageForm="messageForm"
        :handleOutsideClick="handleOutsideClick"
        :closeMessageModal="closeMessageModal"
        :sendMessage="sendMessage"
    />
</template>
