<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useWindowSize } from "@vueuse/core";
import formatPrice from "@/Composables/formatPrice";
import HeartLikeButton from "../HeartLikeButton.vue";

const props = defineProps({
    listing: Object,
});

const page = usePage();
const currentUser = computed(() => {
    return page.props?.auth?.user;
});

const canEdit = computed(() => {
    const hasUser = Boolean(currentUser.value?.id);
    const isOwner = currentUser.value?.id === props.listing.seller?.id;
    return hasUser && isOwner;
});

const { width } = useWindowSize();
function truncateText(length, text) {
    return text.length <= length ? text : `${text.slice(0, length)}...`;
}
</script>

<template>
    <div class="group">
        <div
            class="h-[225px] max-w-full overflow-hidden rounded-md lg:h-[260px] lg:w-[270px]"
        >
            <img
                :src="listing.images[0].url"
                :alt="listing.images[0].url"
                :class="[
                    'h-full w-full object-cover object-center transition-all duration-300 ease-in-out',
                    listing.disabled
                        ? 'opacity-75'
                        : 'md:group-hover:scale-105 md:group-hover:opacity-75',
                ]"
            />
        </div>
        <div class="mt-2 px-2">
            <div class="flex justify-between">
                <h3 class="text-sm font-semibold text-gray-700">
                    <Link
                        v-if="!listing.disabled"
                        :href="route('listings.show', listing.id)"
                    >
                        <span aria-hidden="true" class="absolute inset-0" />
                        {{ truncateText(width < 768 ? 23 : 30, listing.title) }}
                    </Link>
                    <span v-else class="text-gray-400">
                        <!-- Grayed out when disabled -->
                        {{ truncateText(width < 768 ? 23 : 30, listing.title) }}
                        <span class="ml-2 text-xs text-red-500">Sold</span>
                    </span>
                </h3>
                <HeartLikeButton v-if="!canEdit"/>
            </div>
            <p class="mt-1 text-sm text-gray-500">
                {{ listing.artist }}
            </p>
            <p
                class="mt-1 text-sm font-semibold"
                :class="listing.disabled ? 'text-gray-400' : 'text-gray-900'"
            >
                ${{ formatPrice(props.listing.price) }}
            </p>
        </div>
    </div>
</template>
