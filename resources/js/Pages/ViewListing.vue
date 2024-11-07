<script setup>
import { ref } from "vue";
import { Disc, Music, Album, X } from "lucide-vue-next";
import { UserCircleIcon, StarIcon } from "@heroicons/vue/20/solid";
import Tracklist from "@/Components/Tracklist.vue";
import { listingsData } from "../../mockListings.js";

defineProps({
    listing: Object,
});

// Mock data for the listing
// const listing = ref({
//     title: "Original Pressing: Miles Davis - Kind of Blue",
//     artist: "Miles Davis",
//     price: 299.99,
//     condition: "Near Mint",
//     genre: "Jazz",
//     releaseYear: 1959,
//     format: "LP, Album, Mono",
//     description:
//         "Original 1959 mono pressing of Miles Davis' seminal album 'Kind of Blue'. This is a rare find in near mint condition. The vinyl shows minimal signs of play and the cover is in excellent condition with only slight wear on the edges. A must-have for any serious jazz collector.",
//     images: [
//         "https://res.cloudinary.com/oceansf/image/upload/v1728876609/hks5ddopfyhxjdw4gng1.webp",
//         "https://res.cloudinary.com/oceansf/image/upload/v1728876609/knv7c27fchmibi4q7cuc.webp",
//         "https://res.cloudinary.com/oceansf/image/upload/v1728876608/b1t9628ictltt8x7qxdy.webp",
//         "https://res.cloudinary.com/oceansf/image/upload/v1728876609/wziomkl8z9h24t5tu5lf.webp",
//         "https://res.cloudinary.com/oceansf/image/upload/v1728876609/jggjatnyalqzjd4gigbc.webp",
//         "https://res.cloudinary.com/oceansf/image/upload/v1728876609/nsytezhib398ghwxgag3.webp",
//     ],
//     seller: {
//         name: "VinylVault",
//         avatar: "/placeholder.svg?height=100&width=100&text=VV",
//         rating: 4.9,
//         reviews: 382,
//     },
// });

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
                    <span class="text-3xl font-bold"
                        >${{ listing.price.toFixed(2) }}</span
                    >
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
                            type="button"
                            class="flex-1 rounded-md bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50"
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
                        <Disc class="h-5 w-5 text-gray-500" />
                        <span>{{ listing.genre }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <Music class="h-5 w-5 text-gray-500" />
                        <span>{{ listing.releaseYear }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <Album class="h-5 w-5 text-gray-500" />
                        <span>{{ listing.format }}</span>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h2 class="mb-2 text-xl font-semibold">Description</h2>
                    <p class="text-gray-600">{{ listing.description }}</p>
                </div>

                <div class="border-t pt-4">
                    <h2 class="mb-2 text-xl font-semibold">Tracklist</h2>
                    <Tracklist />
                    <h2 class="my-4 text-xl font-semibold">Have a listen</h2>
                    <iframe
                        style="border-radius: 12px"
                        src="https://open.spotify.com/embed/album/1weenld61qoidwYuZ1GESA?utm_source=generator"
                        width="100%"
                        height="352"
                        frameBorder="0"
                        allowfullscreen=""
                        allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                        loading="lazy"
                    ></iframe>
                </div>

                <div class="border-t pt-4">
                    <h2 class="mb-2 text-xl font-semibold">
                        Seller Information
                    </h2>
                    <div class="flex items-center space-x-4">
                        <UserCircleIcon class="h-12 w-12 rounded-full" />
                        <div>
                            <p class="font-medium">VinylVault</p>
                            <div class="flex items-center">
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <span class="ml-1">4.9 (382 reviews)</span>
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

    <!-- Message Modal -->
    <Teleport to="body">
        <Transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="showMessageModal"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 p-4"
                @click="handleOutsideClick"
            >
                <Transition
                    enter-active-class="transition ease-out duration-300"
                    enter-from-class="opacity-0 scale-95"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-200"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-95"
                >
                    <div
                        v-if="showMessageModal"
                        class="relative w-full max-w-md transform rounded-lg bg-white p-6"
                    >
                        <!-- Close button -->
                        <button
                            @click="closeMessageModal"
                            class="absolute right-2 top-2 text-gray-500 hover:text-gray-700 focus:outline-none"
                            aria-label="Close modal"
                        >
                            <X class="h-6 w-6" />
                        </button>

                        <h2 class="mb-2 text-xl font-semibold">
                            Message Seller
                        </h2>

                        <p class="mb-6 text-gray-700">
                            Have questions for the seller regarding this
                            listing? Ask them here.
                        </p>
                        <form @submit.prevent="sendMessage" class="space-y-4">
                            <div>
                                <label
                                    for="message"
                                    class="block text-sm font-medium text-gray-700"
                                    >Message</label
                                >
                                <textarea
                                    id="message"
                                    v-model="messageForm.message"
                                    rows="4"
                                    placeholder="Request more details or discuss price.."
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                ></textarea>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button
                                    type="button"
                                    @click="closeMessageModal"
                                    class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    class="rounded-md border border-transparent bg-slate-900 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
