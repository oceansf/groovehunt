<script setup>
import { computed, ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
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
    EditIcon,
    MailIcon,
    BarcodeIcon,
    ArrowLeft,
} from "lucide-vue-next";
import { UserCircleIcon, StarIcon } from "@heroicons/vue/20/solid";
import Tracklist from "@/Components/Tracklist.vue";
import Modal from "@/Components/MessageModal.vue";
import ConditionBadge from "@/Components/ConditionBadge.vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { usePage, Head } from "@inertiajs/vue3";
import formatPrice from "@/Composables/formatPrice";
import { Link } from "@inertiajs/vue3";
import { useSwipe } from "@vueuse/core";
import HeartLikeButton from "@/Components/HeartLikeButton.vue";

const el = ref(null);

const { isSwiping, direction } = useSwipe(el, {
    threshold: 50, // Minimum swipe distance
    onSwipeEnd(e) {
        if (direction.value === "left") {
            // Move to next image
            if (currentImageIndex.value < listingData.images.length - 1) {
                currentImageIndex.value++;
            }
        } else if (direction.value === "right") {
            // Move to previous image
            if (currentImageIndex.value > 0) {
                currentImageIndex.value--;
            }
        }
    },
});

dayjs.extend(relativeTime);

const page = usePage();
const currentUser = computed(() => {
    return page.props?.auth?.user;
});

const canEdit = computed(() => {
    const hasUser = Boolean(currentUser.value?.id);
    const isOwner = currentUser.value?.id === listingData.seller?.id;
    return hasUser && isOwner;
});

const props = defineProps({
    listing: Object,
    seller: Object,
    sellerListings: Object,
});

const listingData = props.listing.data;
const sellerData = props.seller.data;
const sellerListingsData = props.sellerListings.data;
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
    <Head>
        <title>{{ listingData.title }}</title>
        <meta name="description" content="Listing information" />
    </Head>
    <div class="container mx-auto h-full max-w-5xl sm:py-6">
        <div class="grid grid-cols-1 gap-4 sm:gap-8 lg:grid-cols-2">
            <!-- Image Gallery -->
            <div class="hidden space-y-4 sm:block">
                <div
                    class="h-[400px] overflow-hidden rounded-lg bg-gray-100 md:h-[488px]"
                >
                    <img
                        :src="listingData.images[currentImageIndex].url"
                        :alt="listingData.title"
                        class="h-full w-full object-cover"
                    />
                </div>
                <div class="grid grid-cols-4 gap-4 md:w-[400px]">
                    <button
                        v-for="(image, index) in listingData.images"
                        :key="index"
                        @click="currentImageIndex = index"
                        class="h-[90px] w-[90px] overflow-hidden rounded-md bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{
                            'ring-2 ring-blue-500': currentImageIndex === index,
                        }"
                    >
                        <img
                            :src="image.url"
                            :alt="`${listingData.title} - Image ${index + 1}`"
                            class="h-full w-full object-cover"
                        />
                    </button>
                </div>
            </div>

            <!-- Image Carousel (Mobile) -->
            <div ref="el" class="relative w-full overflow-hidden md:hidden">
                <div
                    class="flex transition-transform duration-300 ease-in-out"
                    :style="{
                        transform: `translateX(-${currentImageIndex * 100}%)`,
                    }"
                >
                    <div
                        v-for="(image, index) in listingData.images"
                        :key="index"
                        class="h-[400px] w-full flex-shrink-0"
                    >
                        <img
                            :src="image.url"
                            :alt="listingData.title"
                            class="h-full w-full object-cover"
                        />
                    </div>
                </div>

                <!-- Navigation dots -->
                <div
                    class="absolute bottom-4 left-0 right-0 flex justify-center gap-2"
                >
                    <button
                        v-for="(_, index) in listingData.images"
                        :key="index"
                        @click="currentImageIndex = index"
                        class="h-2 w-2 rounded-full transition-colors"
                        :class="[
                            currentImageIndex === index
                                ? 'bg-white'
                                : 'bg-white/50 hover:bg-white/75',
                        ]"
                        aria-label="Go to image"
                    />
                </div>
            </div>

            <div class="sm:hidden flex gap-2 pb-3 pl-2 pt-1 overflow-x-scroll">
                    <button
                        v-for="(image, index) in listingData.images"
                        :key="index"
                        @click="currentImageIndex = index"
                        class="h-[90px] w-[90px] flex-shrink-0 overflow-hidden rounded-md bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{
                            'ring-2 ring-blue-500': currentImageIndex === index,
                        }"
                    >
                        <img
                            :src="image.url"
                            :alt="`${listingData.title} - Image ${index + 1}`"
                            class="h-full w-full object-cover"
                        />
                    </button>
                </div>

            <!-- Listing Details -->
            <div class="space-y-6 px-4">
                <div>
                    <div class="flex items-start justify-between">
                        <h1 class="text-3xl font-bold">
                            {{ listingData.title }}
                        </h1>
                        <Link
                            v-if="canEdit"
                            :href="`/listings/${listingData.id}/edit`"
                            class="inline-flex shrink-0 items-center rounded-md border-gray-300 px-2 py-2 text-sm font-semibold text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 md:border md:px-3"
                        >
                            <EditIcon class="h-6 w-6" />
                            <span class="ml-2 hidden md:inline"
                                >Edit Listing</span
                            >
                        </Link>
                        <HeartLikeButton v-else size="lg" class="sm:pr-4" />
                    </div>
                    <p class="text-xl text-gray-600">
                        {{ listingData.artist }}
                    </p>
                </div>

                <div class="space-y-6 md:w-9/12">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col">
                            <span class="text-3xl font-bold"
                                >${{ listingData.price }}</span
                            >
                            <div
                                class="flex items-center space-x-2 text-xl text-gray-600"
                            >
                                <span v-if="listingData.shipping > 0"
                                    >+${{ formatPrice(listingData.shipping) }}
                                    shipping
                                </span>
                                <span v-else>*FREE shipping</span>
                            </div>
                        </div>
                        <ConditionBadge
                            :condition="listingData.media_condition"
                        />
                    </div>
                    <div v-if="!canEdit" class="space-y-2">
                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                class="flex-1 rounded-md bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600"
                            >
                                Buy Now
                            </button>
                            <button
                                type="button"
                                class="flex-1 rounded-md px-6 py-3 text-sm font-semibold shadow-sm ring-1 ring-inset"
                                data-tip="Seller is not taking offers"
                                :class="[
                                    listingData.allow_offers
                                        ? 'bg-white text-gray-900 ring-slate-300 hover:bg-slate-50'
                                        : 'tooltip cursor-not-allowed bg-gray-200 text-gray-500 ring-gray-300',
                                ]"
                                :disabled="!listingData.allow_offers"
                            >
                                Make Offer
                            </button>
                        </div>
                        <button
                            type="button"
                            class="inline-flex w-full items-center justify-center rounded-md bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50"
                            @click="openMessageModal"
                        >
                            <MailIcon class="mr-2 h-4 w-4 text-gray-700" />
                            Message Seller
                        </button>
                        <p class="text-sm text-gray-600">*You will be redirected to Stripe to complete checkout</p>
                    </div>
                    <!-- TODO - Add ships from location -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <TruckIcon class="h-5 w-5 text-gray-500" />
                            <span>Ships from: {{}}</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <span class="text-gray-600"
                            >Posted
                            {{
                                formatRelativeTime(listingData.created_at)
                            }}</span
                        >
                    </div>
                </div>

                <div v-if="listingData.description" class="border-t pt-4">
                    <h2 class="mb-2 text-xl font-semibold">Description</h2>
                    <p class="text-gray-600">{{ listingData.description }}</p>
                </div>
                <!-- TODO - Make tracklist dynamic -->
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
                                {{ listingData.format }}
                            </p>
                            <p class="flex items-center">
                                <SparklesIcon
                                    class="mr-2 h-4 w-4 text-gray-500"
                                />
                                Media condition:
                                {{ listingData.media_condition }}
                            </p>
                            <p
                                v-if="listingData.sleeve_condition"
                                class="flex items-center"
                            >
                                <DiscAlbumIcon
                                    class="mr-2 h-4 w-4 text-gray-500"
                                />
                                Sleeve condition:
                                {{ listingData.sleeve_condition }}
                            </p>
                            <p
                                v-if="listingData.genre"
                                class="flex items-center"
                            >
                                <MusicIcon class="mr-2 h-4 w-4 text-gray-500" />
                                Genre:
                                {{ listingData.genre }}
                            </p>
                            <p
                                v-if="listingData.speed"
                                class="flex items-center"
                            >
                                <CircleGaugeIcon
                                    class="mr-2 h-4 w-4 text-gray-500"
                                />
                                Speed:
                                {{ listingData.speed }}
                            </p>
                            <p
                                v-if="listingData.color"
                                class="flex items-center"
                            >
                                <PaletteIcon
                                    class="mr-2 h-4 w-4 text-gray-500"
                                />
                                Color:
                                {{ listingData.color }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="space-y-4">
                            <p
                                v-if="listingData.release_country"
                                class="flex items-center"
                            >
                                <GlobeIcon class="mr-2 h-4 w-4 text-gray-500" />
                                Country:
                                {{ listingData.release_country }}
                            </p>
                            <p
                                v-if="listingData.release_year"
                                class="flex items-center"
                            >
                                <CalendarIcon
                                    class="mr-2 h-4 w-4 text-gray-500"
                                />
                                Year:
                                {{ listingData.release_year }}
                            </p>
                            <p
                                v-if="listingData.release_label"
                                class="flex items-center"
                            >
                                <BuildingIcon
                                    class="mr-2 h-4 w-4 text-gray-500"
                                />
                                Record label:
                                {{ listingData.release_label }}
                            </p>
                            <p
                                v-if="listingData.release_cat_no"
                                class="flex items-center"
                            >
                                <HashIcon class="mr-2 h-4 w-4 text-gray-500" />
                                Catalog number: {{ listingData.release_cat_no }}
                            </p>
                            <p
                                v-if="listingData.release_matrix_no"
                                class="flex items-center"
                            >
                                <HashIcon class="mr-2 h-4 w-4 text-gray-500" />
                                Matrix number:
                                {{ listingData.release_matrix_no }}
                            </p>
                            <p
                                v-if="listingData.release_upc"
                                class="flex items-center"
                            >
                                <BarcodeIcon
                                    class="mr-2 h-4 w-4 text-gray-500"
                                />
                                UPC:
                                {{ listingData.release_upc }}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- TODO - Make seller info dynamic -->
                <div class="border-t pt-4">
                    <h2 class="mb-2 text-xl font-semibold">
                        Seller Information
                    </h2>
                    <div class="flex items-center space-x-1">
                        <Link :href="route('profile.show', sellerData.id)">
                            <img
                                v-if="sellerData.avatar_url"
                                :src="sellerData.avatar_url"
                                :alt="sellerData.name"
                                class="h-12 w-12 rounded-full object-cover"
                            />
                            <UserCircleIcon
                                v-else
                                class="h-12 w-12 rounded-full text-gray-300"
                            />
                        </Link>
                        <div class="pl-2">
                            <p class="font-semibold">{{ sellerData.name }}</p>
                            <p class=" text-gray-500">
                                Member since
                                {{
                                    new Date(
                                        sellerData.joined_date,
                                    ).toLocaleDateString("en-US", {
                                        month: "short",
                                        year: "numeric",
                                    })
                                }}
                            </p>
                            <div class="flex items-center">
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <span class="pl-1">4.9 (382 reviews)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <template v-if="sellerListingsData.length > 0">
                    <h2 class="text-xl font-semibold">More from this seller</h2>
                    <div class="grid grid-cols-4 gap-4 md:w-[400px]">
                        <Link
                            v-for="listingData in sellerListingsData"
                            :key="listingData.id"
                            :href="route('listings.show', listingData.id)"
                            class="h-[90px] w-[90px] overflow-hidden rounded-md bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <img
                                :src="listingData.images[0].url"
                                :alt="listingData.title"
                                class="h-full w-full object-cover"
                            />
                        </Link>
                    </div>
                </template>
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
