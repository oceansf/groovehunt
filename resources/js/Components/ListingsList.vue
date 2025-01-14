<script setup>
import { UserCircleIcon, StarIcon } from "@heroicons/vue/20/solid";
import ConditionBadge from "./ConditionBadge.vue";
import formatPrice from "@/Composables/formatPrice";

const props = defineProps({
    listings: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div>
        <header>
            <div class="mb-2 hidden justify-between sm:flex">
                <h2 class="text-slate-500">
                    Showing {{ props.listings.total }}
                    <span v-if="listings.total === 1">result</span
                    ><span v-else>results</span>
                </h2>
                <h1 class="pr-4 text-end text-slate-900">Sold by</h1>
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
                                    'h-[120px] w-[120px] rounded-lg object-cover object-center transition-all duration-300 ease-in-out sm:h-[200px] sm:w-[200px]',
                                    listing.disabled
                                        ? 'opacity-75'
                                        : 'md:group-hover:scale-105 md:group-hover:opacity-75',
                                ]"
                            />

                            <div class="flex flex-col justify-between">
                                <div>
                                    <h1 class="font-semibold sm:text-xl">
                                        {{ listing.title }}
                                    </h1>
                                    <h2
                                        class="text-sm text-gray-600 sm:text-lg"
                                    >
                                        {{ listing.artist }}
                                    </h2>
                                    <div>
                                        <h2
                                            class="mt-1 font-semibold sm:text-xl"
                                        >
                                            ${{ listing.price }}
                                        </h2>
                                        <h3 class="text-gray-600">
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

                        <div class="flex flex-col">
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
                                            v-if="listing.seller.avatar"
                                            :src="listing.seller.avatar"
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

                            <div class="mt-4">
                                <h1>Ships from Austin, TX</h1>
                            </div>
                        </div>
                    </div>
                </Link>
                <div class="mx-auto h-[1px] w-[97.5%] bg-black/5"></div>
            </li>
        </ul>
    </div>
</template>
