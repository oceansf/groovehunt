<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { router, Head } from "@inertiajs/vue3";
import { emitter } from "../Shared/event-bus";
import { useIntersectionObserver } from "@vueuse/core";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import {
    ChevronDownIcon,
    FunnelIcon,
    ListBulletIcon,
    Squares2X2Icon,
} from "@heroicons/vue/20/solid";
import ListingsGrid from "@/Components/Listing/ListingsGrid.vue";
import ListingsList from "@/Components/Listing/ListingsList.vue";
import MobileFilterDialog from "@/Components/MobileFilterDialog.vue";
import FiltersSidebar from "@/Components/FiltersSidebar.vue";

const props = defineProps({
    listings: Object,
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,

    search: String,
    filters: Array,
    sort: Object,
    view: String,
});

// Event listeners setup
onMounted(() => {
    emitter.on("search", handleSearch);
});

onUnmounted(() => {
    emitter.off("search", handleSearch);
});

// State management
const mobileFiltersOpen = ref(false);
const currentSearch = ref(props.search || "");
const currentFilters = ref(props.filters || []);
const currentSort = ref(props.sort || {});
const view = ref(props.view || "grid");

const bottom = ref(null);

// Unified update method
const updateListings = (params = {}) => {
    router.get(
        "/",
        {
            search: params.search ?? currentSearch.value,
            filters: params.filters ?? currentFilters.value,
            sort_by: params.sort_by ?? currentSort.value.field,
            sort_direction:
                params.sort_direction ?? currentSort.value.direction,
            view: params.view ?? view.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};

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

// Event handlers
const handleSearch = (query) => {
    currentSearch.value = query;
    updateListings({ search: query });
};

const handleFilterChange = (newFilters) => {
    currentFilters.value = newFilters;
    updateListings({ filters: newFilters });
};

const handleSortChange = (newSort) => {
    currentSort.value = newSort;
    updateListings({
        sort_by: newSort.field,
        sort_direction: newSort.direction,
    });
};

const clearFilters = () => {
    currentFilters.value = [];
    emit("handleSubmit", currentFilters.value);
    closeDialog();
};

const handleViewChange = () => {
    const newView = view.value === "grid" ? "list" : "grid";
    view.value = newView;
    updateListings({ view: newView });
};

const sortOptions = [
    { name: "Most Popular", field: "popularity", direction: "desc" },
    { name: "Newest", field: "created_at", direction: "desc" },
    { name: "Seller Rating", field: "seller_rating", direction: "desc" },
    { name: "Price: Low to High", field: "price", direction: "asc" },
    { name: "Price: High to Low", field: "price", direction: "desc" },
];
</script>

<template>
    <Head>
        <title>Market</title>
        <meta name="description" content="Buy and sell music formats" />
    </Head>
    <div class="bg-slate-50">
        <div>
            <MobileFilterDialog
                v-model:mobileFiltersOpen="mobileFiltersOpen"
                @handle-submit="handleFilterChange"
                :filters="currentFilters"
            />

            <main class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="flex items-end justify-between border-b border-gray-200 px-3 pb-4 pt-12 md:px-0"
                >
                    <div>
                        <h1
                            class="text-4xl font-bold tracking-tight text-gray-900 sm:mb-2"
                        >
                            Market
                        </h1>
                        <p class="hidden text-gray-600 sm:inline">
                            Buy and sell from music collectors around the world
                        </p>
                    </div>
                    <!-- Sort & Filter controls -->
                    <div class="flex items-center">
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="group inline-flex justify-center text-sm font-semibold text-gray-700 hover:text-gray-900"
                                >
                                    <span class="sm:inline-block">
                                        {{
                                            props.sort?.field
                                                ? (sortOptions.find(
                                                      (option) =>
                                                          option.field ===
                                                              props.sort
                                                                  .field &&
                                                          option.direction ===
                                                              props.sort
                                                                  .direction,
                                                  )?.name ?? "Sort")
                                                : "Sort"
                                        }}
                                    </span>
                                    <ChevronDownIcon
                                        class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                        aria-hidden="true"
                                    />
                                </MenuButton>
                            </div>

                            <transition
                                enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <MenuItems
                                    class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                                >
                                    <div class="py-1">
                                        <MenuItem
                                            v-for="option in sortOptions"
                                            :key="option.name"
                                            v-slot="{ active }"
                                        >
                                            <a
                                                href="#"
                                                @click.prevent="
                                                    handleSortChange({
                                                        field: option.field,
                                                        direction:
                                                            option.direction,
                                                    })
                                                "
                                                :class="[
                                                    currentSort.field ===
                                                        option.field &&
                                                    currentSort.direction ===
                                                        option.direction
                                                        ? 'font-medium text-gray-900'
                                                        : 'text-gray-500',
                                                    active ? 'bg-gray-100' : '',
                                                    'block px-4 py-2 text-sm',
                                                ]"
                                            >
                                                {{ option.name }}
                                            </a>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>

                        <button
                            @click="handleViewChange"
                            type="button"
                            class="-m-2 ml-5 p-2 text-gray-400 hover:text-gray-500 sm:ml-7"
                        >
                            <span class="sr-only">View list</span>
                            <div v-if="view === 'grid'">
                                <ListBulletIcon
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                />
                            </div>
                            <div v-else>
                                <Squares2X2Icon
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                />
                            </div>
                        </button>

                        <button
                            type="button"
                            class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden"
                            @click="mobileFiltersOpen = true"
                        >
                            <span class="sr-only">Filters</span>
                            <FunnelIcon class="h-5 w-5" aria-hidden="true" />
                        </button>
                    </div>
                </div>

                <section aria-labelledby="filters-heading" class="pb-24 pt-3">
                    <h2 id="filters-heading" class="sr-only">Filters</h2>
                    <div class="grid grid-cols-1 gap-y-10 lg:grid-cols-5">
                        <!-- Filters side menu -->
                        <FiltersSidebar
                            @handle-change="handleFilterChange"
                            @clear-filters="clearFilters"
                            :filters="currentFilters"
                        />

                        <!-- Listings grid -->
                        <div v-if="view === 'grid'" class="lg:col-span-4">
                            <ListingsGrid :listings="listings" />
                        </div>

                        <!-- Listings list -->
                        <div v-else class="lg:col-span-4">
                            <ListingsList :listings="listings" />
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
</template>
