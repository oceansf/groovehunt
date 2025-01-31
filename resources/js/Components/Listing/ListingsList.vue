<script setup>
import { ref, computed } from "vue";
import { useIntersectionObserver, useWindowSize } from "@vueuse/core";
import { usePage } from "@inertiajs/vue3";
import { UserCircleIcon, StarIcon } from "@heroicons/vue/20/solid";
import ConditionBadge from "../ConditionBadge.vue";
import formatPrice from "@/Composables/formatPrice";
import axios from "axios";
import ScrollToTop from "../ScrollToTop.vue";
import HeartLikeButton from "../HeartLikeButton.vue";

const props = defineProps({
    listings: {
        type: Object,
        required: true,
    },
});

const page = usePage();
const currentUser = computed(() => {
    return page.props?.auth?.user;
});

const canEdit = computed(() => {
    const hasUser = Boolean(currentUser.value?.id);
    const isOwner = currentUser.value?.id === props.listings.seller?.id;
    return hasUser && isOwner;
});

const bottom = ref(null);

// Infinite scrolling
const { stop } = useIntersectionObserver(bottom, ([{ isIntersecting }]) => {
    if (!isIntersecting || !props.listings?.meta?.next_cursor) {
        return;
    }
    const serializableListings = JSON.parse(JSON.stringify(props.listings)); // added
    axios
        .get(
            `${props.listings.meta.path}?cursor=${props.listings.meta.next_cursor}`,
        )
        .then((response) => {
            props.listings.data = [
                ...serializableListings.data,
                ...response.data.data,
            ];

            props.listings.meta = response.data.meta;

            if (!props.listings.meta.next_cursor) {
                stop();
            }
        });
});

const { width } = useWindowSize();
function truncateText(length, text) {
    return text.length <= length ? text : `${text.slice(0, length)}...`;
}
</script>

<template>
    <div>
        <header>
            <div class="mb-2 flex justify-between px-4">
                <h2 class="text-slate-500">
                    Showing {{ props.listings.total }}
                    <span v-if="listings.total === 1">result</span
                    ><span v-else>results</span>
                </h2>
                <h2 class="text-end text-slate-900">Sold by</h2>
            </div>
        </header>
        <ul role="list">
            <li v-for="listing in listings.data" :key="listing.id">
                <Link :href="route('listings.show', listing.id)">
                    <div
                        class="flex justify-between rounded-xl p-2 transition hover:bg-black/5 sm:p-3"
                    >
                        <div class="flex gap-2 sm:gap-4">
                            <img
                                :src="listing.images[0].url"
                                :alt="listing.images[0].url"
                                :class="[
                                    'h-[120px] w-[120px] rounded-lg object-cover object-center transition-all duration-300 ease-in-out sm:h-[190px] sm:w-[190px]',
                                    listing.disabled
                                        ? 'opacity-75'
                                        : 'md:group-hover:scale-105 md:group-hover:opacity-75',
                                ]"
                            />

                            <div class="flex flex-col justify-between">
                                <div>
                                    <h1 class="font-semibold sm:text-lg">
                                        {{
                                            truncateText(
                                                width < 768 ? 23 : 30,
                                                listing.title,
                                            )
                                        }}
                                    </h1>
                                    <h2 class="text-sm text-gray-600">
                                        {{ listing.artist }}
                                    </h2>
                                    <div>
                                        <h2
                                            class="mt-1 font-semibold sm:text-lg"
                                        >
                                            ${{ listing.price }}
                                        </h2>
                                        <h3
                                            class="text-xs text-gray-600 sm:text-sm"
                                        >
                                            <span v-if="listing.shipping > 0">
                                                <em
                                                    >+${{
                                                        formatPrice(
                                                            listing.shipping,
                                                        )
                                                    }}
                                                    shipping</em
                                                >
                                            </span>
                                            <span v-else>
                                                <em>FREE shipping</em>
                                            </span>
                                        </h3>
                                    </div>
                                </div>
                                <div
                                    class="hidden flex-col gap-2 text-sm sm:flex"
                                >
                                    <span v-if="listing.media_condition"
                                        >Media condition:
                                        <ConditionBadge
                                            :condition="listing.media_condition"
                                            size="sm"
                                    /></span>
                                    <span v-if="listing.sleeve_condition"
                                        >Sleeve condition:
                                        <ConditionBadge
                                            :condition="
                                                listing.sleeve_condition
                                            "
                                            size="sm"
                                    /></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col justify-between">
                            <div>
                                <div
                                    class="flex items-center justify-end gap-1"
                                >
                                    <Link
                                        :href="
                                            route(
                                                'profile.show',
                                                listing.seller.id,
                                            )
                                        "
                                    >
                                        <img
                                            v-if="listing.seller.avatar_url"
                                            :src="listing.seller.avatar_url"
                                            :alt="listing.seller.name"
                                            class="h-6 w-6 rounded-full object-cover sm:h-8 sm:w-8"
                                        />
                                        <UserCircleIcon
                                            v-else
                                            class="h-6 w-6 rounded-full text-gray-300 sm:h-8 sm:w-8"
                                        />
                                    </Link>
                                    <span class="text-xs sm:text-sm">{{
                                        listing.seller.name
                                    }}</span>
                                </div>
                                <div
                                    class="mt-1 flex items-center justify-end text-xs sm:text-sm"
                                >
                                    <StarIcon class="h-4 w-4 text-yellow-400" />
                                    <span class="pl-1"
                                        >4.9 (382<span class="hidden sm:inline">
                                            reviews</span
                                        >)
                                    </span>
                                </div>
                            </div>

                            <div class="text-xs sm:text-sm">
                                <h1>Ships from Austin, TX</h1>
                            </div>
                            <!-- Add to wishlist btn -->
                            <button
                                class="mt-1 flex items-center gap-1 rounded-lg border px-2 py-1 hover:bg-black/5"
                            >
                                <HeartLikeButton />
                                <span class="text-nowrap text-xs sm:text-sm"
                                    >Add to wishlist</span
                                >
                            </button>
                        </div>
                    </div>
                </Link>
                <div class="mx-auto h-[1px] w-[97.5%] bg-black/5"></div>
            </li>
        </ul>
        <ScrollToTop />
        <div ref="bottom" class="-translate-y-32"></div>
    </div>
</template>
