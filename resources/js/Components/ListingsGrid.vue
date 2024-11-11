<script setup>
import { onMounted, ref } from "vue";
import ListingItem from "@/Components/ListingItem.vue";
import { usePage, router, Link } from "@inertiajs/vue3";

const props = defineProps({
    listings: {
        type: Object,
        required: true,
    },
});

const items = ref(props.listings.data);
const initialUrl = usePage().url;

const loadMoreItems = () => {
    if (!props.listings.next_page_url) {
        return;
    }

    router.get(
        props.listings.next_page_url,
        {},
        {
            preserveState: true,
            preserveScroll: true,
            onSuccess: (page) => {
                window.history.replaceState({}, "", initialUrl);
                items.value = [...items.value, ...page.props.listings.data];
            },
        },
    );
};

const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                loadMoreItems();
            }
        });
    },
    {
        rootMargin: "0px 0px 400px 0px",
    },
);

const landmark = ref(null);

onMounted(() => {
    observer.observe(landmark.value);
});
</script>

<template>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl lg:max-w-6xl">
            <div class="mt-2 grid grid-cols-2 gap-x-1 gap-y-8 lg:grid-cols-4">
                <div
                    v-for="listing in items"
                    :key="listing.id"
                    class="group relative"
                >
                    <ListingItem :listing="listing" />
                </div>
            </div>
        </div>
    </div>
    <div ref="landmark"></div>
</template>
