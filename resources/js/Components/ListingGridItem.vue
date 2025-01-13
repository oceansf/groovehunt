<script setup>
import { computed } from "vue";
import { useWindowSize } from "@vueuse/core";

const props = defineProps({
    listing: Object,
});

const { width } = useWindowSize();
function truncateText(length, text) {
    return text.length <= length ? text : `${text.slice(0, length)}...`;
}

const formattedPrice = computed(() => {
    const numPrice = parseFloat(props.listing.price);
    return numPrice % 1 === 0 ? numPrice.toFixed(0) : numPrice.toFixed(2);
});
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
        <div class="mt-2 flex justify-between">
            <div class="flex justify-between">
                <div class="pl-1">
                    <h3 class="text-sm font-semibold text-gray-700">
                        <Link
                            v-if="!listing.disabled"
                            :href="route('listings.show', listing.id)"
                        >
                            <span aria-hidden="true" class="absolute inset-0" />
                            {{
                                truncateText(
                                    width < 768 ? 23 : 30,
                                    listing.title,
                                )
                            }}
                        </Link>
                        <span v-else class="text-gray-400">
                            <!-- Grayed out when disabled -->
                            {{
                                truncateText(
                                    width < 768 ? 23 : 30,
                                    listing.title,
                                )
                            }}
                            <span class="ml-2 text-xs text-red-500">Sold</span>
                        </span>
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ listing.artist }}
                    </p>
                    <p
                        class="text-sm mt-1 font-semibold"
                        :class="
                            listing.disabled ? 'text-gray-400' : 'text-gray-900'
                        "
                    >
                        ${{ formattedPrice }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
